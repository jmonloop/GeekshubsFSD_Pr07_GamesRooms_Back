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

        try {

            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:255',
                'game_id' => 'required|integer',
                'ownerNickname' => 'required|string',
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
                'ownerNickname' => $request->ownerNickname,
                'private' => $request->private,
                'password' => $request->password
            ]);

            $data = [
                'data' => $party,
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

    //GET PARTY BY ID
    public function getById($id)
    {
        try {

            $party = Party::find($id);

            if (!$party) {
                return response()->json([
                    'message' => 'Party not found'
                ], 404);
            }

            $data = [
                'data' => $party,
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

    //GET ALL PARTIES
    public function getAll()
    {

        try {

            $parties = Party::all();

            if (!$parties) {
                return response()->json([
                    'message' => 'No parties found'
                ], 404);
            }

            $data = [
                'data' => $parties,
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

    //GET PARTIES BY USER
    public function getByUser($ownerNickname)
    {

        try {

            $parties = Party::where('ownerNickname', $ownerNickname)->get();

            if (!$parties) {
                return response()->json([
                    'message' => 'No parties found'
                ], 404);
            }

            $data = [
                'data' => $parties,
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

    //GET PARTIES BY GAME
    public function getByGame($id)
    {

        try {

            $parties = Party::where('game_id', $id)->get();

            if (!$parties) {
                return response()->json([
                    'message' => 'No parties found'
                ], 404);
            }

            $data = [
                'data' => $parties,
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

    //UPDATE PARTY
    public function update($id, Request $request)
    {

        try {
            //Get user by auth token
            $userAuth = auth()->user();


            $validator = Validator::make($request->all(), [
                'title' => 'string|max:255',
                'game_id' => 'integer',
                'ownerNickname' => 'string',
                'private' => 'boolean',
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

            //The party can only be updated by an admin or the owner of the party
            if (($userAuth->isAdmin == false) && ($userAuth->nickname != $party->ownerNickname)) {
                return response()->json([
                    'success' => false,
                    'message' => "You don't have permissions to perform this action"
                ], 400);
            }


            $party->fill($request->all())->save();

            $data = [
                'data' => $party,
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

    //DELETE PARTY
    public function delete($id)
    {

        try {
            //Get user by auth token
            $userAuth = auth()->user();



            $party = Party::find($id);

            if (!$party) {
                return response()->json([
                    'message' => 'Party not found'
                ], 404);
            }

            //The party can only be deleted by an admin or the owner of the party
            if (($userAuth->isAdmin == false) && ($userAuth->nickname != $party->ownerNickname)) {
                return response()->json([
                    'success' => false,
                    'message' => "You don't have permissions to perform this action"
                ], 400);
            }

            $party->delete();

            return response()->json([
                'message' => 'Party deleted'
            ], 200);
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}
