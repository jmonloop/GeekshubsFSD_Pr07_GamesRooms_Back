<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    // use HasFactory;

    protected $fillable = [
        'party_id',
        'user_id',
        'text'
    ];

    public function user (){
        return $this -> belongsTo(User::class);
    }

    public function party (){
        return $this -> belongsTo(Party::class);
    }
    
}
