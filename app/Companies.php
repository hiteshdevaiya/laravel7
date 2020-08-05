<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Companies extends Model
{
    public $timestamps = false;
    protected $table = 'companies';
	
    protected $fillable = ['id',
    'name',
    'email',
    'logo',
    'website'];
 
    //protected $hidden = ['user_password'];
	
	//use user id of user
	protected $primaryKey = 'id';
}
