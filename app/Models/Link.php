<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    use HasFactory;

    protected $fillable = [
        'to',
        'from',
        'user_id',
        'views'
    ];

    public function user (){
        return $this->belongsTo(User::class);
    }
    public function analytics () {
        return $this->hasMany(Analytic::class);
    }
}
