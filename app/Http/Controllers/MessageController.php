<?php

namespace App\Http\Controllers;

use App\Models\Party;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Membership;
use App\Models\Game;
use App\Models\Message;

class MessageController extends Controller
{
    //CREATE MESSAGE
    public function create(Request $request)
    {

        try {

            $validator = Validator::make($request->all(), [
                'party_id' => 'required|integer',
                'user_id' => 'required|integer',
                'text' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'Validation failed',
                    $validator->errors()
                ], 400);
            }

            $message = Message::create([
                'party_id' => $request->party_id,
                'user_id' => $request->user_id,
                'text' => $request->text
            ]);

            $data = [
                'data' => $message,
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

    //GET MESSAGE BY ID
    public function getById($id)
    {

        try {

            $message = Message::find($id);

            if (!$message) {
                return response()->json([
                    'message' => 'Message not found'
                ], 404);
            }

            $data = [
                'data' => $message,
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

    //GET ALL MESSAGES
    public function getAll()
    {

        try {

            $messages = Message::all();

            if (!$messages) {
                return response()->json([
                    'message' => 'No messages found'
                ], 404);
            }

            $data = [
                'data' => $messages,
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

    //UPDATE MESSAGE
    public function update($id, Request $request)
    {

        try {

            //Get user by auth token
            $userAuth = auth()->user();

            $validator = Validator::make($request->all(), [
                'text' => 'required|string',

            ]);

            if ($validator->fails()) {
                return response()->json([
                    'Validation failed',
                    $validator->errors()
                ], 400);
            }

            $message = Message::find($id);

            if (!$message) {
                return response()->json([
                    'message' => 'Message not found'
                ], 404);
            }

            //The message can only be updated by an Admin or the user who created it
            if (($userAuth->isAdmin == false) && ($userAuth->id != $message->user_id)) {
                return response()->json([
                    'success' => false,
                    'message' => "You don't have permissions to perform this action"
                ], 400);
            }

            $message->text = $request->text;

            $data = [
                'data' => $message,
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

    //DELETE MESSAGE
    public function delete($id)
    {

        try {

            //Get user by auth token
            $userAuth = auth()->user();

            $message = Message::find($id);

            if (!$message) {
                return response()->json([
                    'message' => 'Message not found'
                ], 404);
            }

            //The message can only be deleted by an Admin or the user who created it
            if (($userAuth->isAdmin == false) && ($userAuth->id != $message->user_id)) {
                return response()->json([
                    'success' => false,
                    'message' => "You don't have permissions to perform this action"
                ], 400);
            }

            $message->delete();

            return response()->json([
                'message' => 'Message deleted'
            ], 200);
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}
