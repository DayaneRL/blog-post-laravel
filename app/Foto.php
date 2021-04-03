<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Foto extends Model
{
    use SoftDeletes;
    protected $table    = 'fotos';

    protected $fillable = [
        'fotos'
    ];
    public $timestamps   = true;

}
