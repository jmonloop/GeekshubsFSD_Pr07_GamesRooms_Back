<?php

namespace App\Http\Controllers;

use App\Models\Membership;
use App\Models\Party;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MembershipController extends Controller
{
    //CREATE MEMBERSHIP
    public function create(Request $request)
    {

        try {

            $validator = Validator::make($request->all(), [
                'user_id' => 'required|integer',
                'party_id' => 'required|integer'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'Validation failed',
                    $validator->errors()
                ], 400);
            }

            $membership = Membership::create([
                'user_id' => $request->user_id,
                'party_id' => $request->party_id
            ]);

            $data = [
                'data' => $membership,
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

    //GET ALL MEMBERSHIPS
    public function getAll()
    {
        try {
            $memberships = Membership::all();

            $data = [
                'data' => $memberships,
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

    //GET BY USER ID
    public function getByUser($user_id)
    {

        try {

            $memberships = Membership::where('user_id', $user_id)->get();

            $data = [
                'data' => $memberships,
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

    //GET BY PARTY ID
    public function getByParty($party_id)
    {
        try {
            $memberships = Membership::where('party_id', $party_id)->get();

            $data = [
                'data' => $memberships,
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

    //GET BY ID
    public function get($id)
    {
        try {
            $membership = Membership::find($id);

            $data = [
                'data' => $membership,
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

    //DELETE
    public function delete($id)
    {

        try {
            //Get user by auth token
            $userAuth = auth()->user();

            $membership = Membership::find($id);

            if (!$membership) {
                return response()->json(['message' => 'Membership not found'], 404);
            } else {

                //The membership can only be deleted by an Admin or the user who created it
                if (($userAuth->isAdmin == false) && ($userAuth->id != $membership->user_id)) {
                    return response()->json([
                        'success' => false,
                        'message' => "You don't have permissions to perform this action"
                    ], 400);
                }

                $membership->delete();

                return response()->json(['message' => 'The membership has been removed'], 200);
            }
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}
