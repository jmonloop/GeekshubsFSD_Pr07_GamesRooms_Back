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

        return response()->json($membership, 200);
    }

    //GET ALL MEMBERSHIPS
    public function getAll()
    {
        $memberships = Membership::all();

        return response()->json($memberships, 200);
    }

    //GET BY USER ID
    public function getByUser($user_id)
    {
        $memberships = Membership::where('user_id', $user_id)->get();

        return response()->json($memberships, 200);
    }

    //GET BY PARTY ID
    public function getByParty($party_id)
    {
        $memberships = Membership::where('party_id', $party_id)->get();

        return response()->json($memberships, 200);
    }

    //GET BY ID
    public function get($id)
    {
        $membership = Membership::find($id);

        return response()->json($membership, 200);
    }

    //DELETE
    public function delete($id)
    {
        $membership = Membership::find($id);

        if(!$membership){
            return response()->json(['message' => 'Membership not found'], 404);
        } else {
            $membership->delete();

            return response()->json(['message' => 'The membership has been removed'], 200);
        }
    }
}
