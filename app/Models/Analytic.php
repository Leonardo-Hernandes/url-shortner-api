<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Analytic extends Model
{
    use HasFactory;

    protected $fillable = [
        'ip',
        'link_id',
        'user-agent',
    ];

    public function link (){
        return $this->belongsTo(Link::class);
    }
}
