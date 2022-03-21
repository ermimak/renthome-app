<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Home extends Model
{
    use HasFactory;

    // one home belongs to one user only
    public function users() {
        return $this->belongsToMany(User::class);
    }

    // one home has only one contract
    public function contract() {
        return $this->hasOne(Contract::class);
    }

    //has one room
    public function room() {
        return $this->hasOne(Room::class);
    }
}
