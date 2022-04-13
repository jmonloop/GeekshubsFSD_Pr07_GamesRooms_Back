<?php

namespace App\Http\Controllers;

use App\Models\Party;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Game;
use App\Models\User;

class PartyController extends Controller
{
    //CREATE PARTY
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'game_id' => 'required|integer',
            'userOwner' => 'required|integer',
            'private' => 'required|boolean',
            'password' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'Validation failed',
                $validator->errors()
            ], 400);
        }

        $party = Party::create([
            'title' => $request->title,
            'game_id' => $request->game_id,
            'userOwner' => $request->userOwner,
            'private' => $request->private,
            'password' => $request->password
        ]);
    
        return response()->json($party, 200);
    }

    //GET PARTY BY ID
    public function getById($id)
    {
        $party = Party::find($id);

        if (!$party) {
            return response()->json([
                'message' => 'Party not found'
            ], 404);
        }

        return response()->json($party, 200);
    }

    //GET ALL PARTIES
    public function getAll()
    {
        $parties = Party::all();

        if (!$parties) {
            return response()->json([
                'message' => 'No parties found'
            ], 404);
        }

        return response()->json($parties, 200);
    }

    //GET PARTIES BY USER
    public function getByUser($id)
    {
        $parties = Party::where('userOwner', $id)->get();

        if (!$parties) {
            return response()->json([
                'message' => 'No parties found'
            ], 404);
        }

        return response()->json($parties, 200);
    }

    //GET PARTIES BY GAME
    public function getByGame($id)
    {
        $parties = Party::where('game_id', $id)->get();

        if (!$parties) {
            return response()->json([
                'message' => 'No parties found'
            ], 404);
        }

        return response()->json($parties, 200);
    }

    //UPDATE PARTY
    public function update($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'game_id' => 'required|integer',
            'userOwner' => 'required|integer',
            'private' => 'required|boolean',
            'password' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'Validation failed',
                $validator->errors()
            ], 400);
        }

        $party = Party::find($id);

        if (!$party) {
            return response()->json([
                'message' => 'Party not found'
            ], 404);
        }

        $party->title = $request->title;
        $party->game_id = $request->game_id;
        $party->userOwner = $request->userOwner;
        $party->private = $request->private;
        $party->password = $request->password;
        $party->save();

        return response()->json($party, 200);
    }

    //DELETE PARTY
    public function delete($id)
    {
        $party = Party::find($id);

        if (!$party) {
            return response()->json([
                'message' => 'Party not found'
            ], 404);
        }

        $party->delete();

        return response()->json([
            'message' => 'Party deleted'
        ], 200);
    }

}
