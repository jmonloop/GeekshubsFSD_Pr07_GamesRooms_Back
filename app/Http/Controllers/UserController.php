<?php




namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

//CONSOLE.LOG CUSTOM FUNCTION
function conslog($data)
{
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
};

class UserController extends Controller
{

    //GET USER BY ID
    public function getById($id)
    {
        try {
            $user = User::find($id);

            $data = [
                'data' => $user,
                'success' => true,
            ];
            return response()->json($data, 200);
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }


    //GET ALL USERS
    public function getAll()
    {
        try {
            $users = User::all();

            $data = [
                'data' => $users,
                'success' => true,
            ];
            return response()->json($data, 200);
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }


    //UPDATE USER
    public function update(Request $request, $id)
    {

        try {
            $userAuth = auth()->user();

            if (($userAuth->isAdmin == false) && ($userAuth->id != $id)) {
                return response()->json([
                    'success' => false,
                    'message' => "You don't have permissions to perform this action"
                ], 400);
            }

            $validator = Validator::make($request->all(), [
                'email' => 'required|string|email|max:255|unique:users',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'Validation failed',
                    $validator->errors()
                ], 400);
            }

            $user = User::find($id);
            $user->email = $request->email;

            $user->save();

            $data = [
                'data' => $user,
                'success' => true,
            ];
            return response()->json($data, 200);
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }


    //DELETE USER
    public function delete($id)
    {
        try {
            $userAuth = auth()->user();

            if (($userAuth->isAdmin == false) && ($userAuth->id != $id)) {
                return response()->json([
                    'success' => false,
                    'message' => "You don't have permissions to perform this action"
                ], 400);
            }


            $user = User::find($id);
            $user->delete();

            $data = [
                'data' => $user,
                'success' => true,
            ];
            return response()->json($data, 200);
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}
