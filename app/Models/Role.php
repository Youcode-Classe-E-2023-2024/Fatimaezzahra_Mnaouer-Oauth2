<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable =[
        'name',
    ];


    public function permission(){
        return $this->belongsToMany(Permission::class,'role_has_permission');
    }

    public function user(){
        return $this->belongsToMany(User::class,'user_has_role');
    }
}
