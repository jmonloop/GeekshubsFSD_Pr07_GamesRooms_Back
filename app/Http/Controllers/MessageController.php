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
        ]);
    
        return response()->json($message, 200);
    }

    //GET MESSAGE BY ID
    public function getById($id)
    {
        $message = Message::find($id);

        if (!$message) {
            return response()->json([
                'message' => 'Message not found'
            ], 404);
        }

        return response()->json($message, 200);
    }

    //GET ALL MESSAGES
    public function getAll()
    {
        $messages = Message::all();

        if (!$messages) {
            return response()->json([
                'message' => 'No messages found'
            ], 404);
        }

        return response()->json($messages, 200);
    }


    //UPDATE MESSAGE
    public function update($id, Request $request)
    {
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

        $message->text = $request->text;
    

        return response()->json($message, 200);
    }

    //DELETE MESSAGE
    public function delete($id)
    {
        $message = Message::find($id);

        if (!$message) {
            return response()->json([
                'message' => 'Message not found'
            ], 404);
        }

        $message->delete();

        return response()->json([
            'message' => 'Message deleted'
        ], 200);
    }

}
