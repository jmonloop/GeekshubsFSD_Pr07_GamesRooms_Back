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
        try {

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

            $data = [
                'data' => $game,
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

    //GET GAME BY ID
    public function getById($id)
    {
        try {
            $game = Game::find($id);

            if (!$game) {
                return response()->json([
                    'message' => 'Game not found'
                ], 404);
            }

            $data = [
                'data' => $game,
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

    //GET ALL GAMES
    public function getAll()
    {
        try {
            $games = Game::all();

            if (!$games) {
                return response()->json([
                    'message' => 'No games found'
                ], 404);
            }

            $data = [
                'data' => $games,
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


    //UPDATE GAME
    public function update($id, Request $request)
    {
        try {
            //Get user by auth token
            $userAuth = auth()->user();

            //The game can only be updated by an Admin
            if ($userAuth->isAdmin == false) {
                return response()->json([
                    'success' => false,
                    'message' => "You don't have permissions to perform this action"
                ], 400);
            }

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


            $data = [
                'data' => $game,
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

    //DELETE GAME
    public function delete($id)
    {
        try {
            //Get user by auth token
            $userAuth = auth()->user();

             //The game can only be deleted by an Admin
            if ($userAuth->isAdmin == false) {
                return response()->json([
                    'success' => false,
                    'message' => "You don't have permissions to perform this action"
                ], 400);
            }

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
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}
