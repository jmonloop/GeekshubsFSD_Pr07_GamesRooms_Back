<?php

namespace App\Http\Controllers;

use App\Models\Party;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Membership;
use App\Models\Game;

class GameController extends Controller
{
    //CREATE GAME
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'image' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'Validation failed',
                $validator->errors()
            ], 400);
        }

        $game = Game::create([
            'title' => $request->title,
            'image' => $request->image,
        ]);
    
        return response()->json($game, 200);
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
