<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    //one home has only one contract
    public function home() {
        return $this->belongsTo(Home::class);
    }
}
