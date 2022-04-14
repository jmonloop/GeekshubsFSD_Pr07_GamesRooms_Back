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

    //GET GAME BY ID
    public function getById($id)
    {
        $game = Game::find($id);

        if (!$game) {
            return response()->json([
                'message' => 'Game not found'
            ], 404);
        }

        return response()->json($game, 200);
    }

    //GET ALL GAMES
    public function getAll()
    {
        $games = Game::all();

        if (!$games) {
            return response()->json([
                'message' => 'No games found'
            ], 404);
        }

        return response()->json($games, 200);
    }


    //UPDATE GAME
    public function update($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|string',
        
        ]);

        if ($validator->fails()) {
            return response()->json([
                'Validation failed',
                $validator->errors()
            ], 400);
        }

        $game = Game::find($id);

        if (!$game) {
            return response()->json([
                'message' => 'Game not found'
            ], 404);
        }

        $game->title = $request->title;
    

        return response()->json($game, 200);
    }

    //DELETE GAME
    public function delete($id)
    {
        $game = Game::find($id);

        if (!$game) {
            return response()->json([
                'message' => 'Game not found'
            ], 404);
        }

        $game->delete();

        return response()->json([
            'message' => 'Game deleted'
        ], 200);
    }

}
