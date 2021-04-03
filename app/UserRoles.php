<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRoles extends Model
{
    protected $table    = 'user_roles';

    protected $fillable = [
        'user_id','roles_id'
    ];
    public $timestamps   = false;

    public function roles() {
        return $this->belongsTo('App\Roles','roles_id', 'id');
    }   

    public function users() {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}
