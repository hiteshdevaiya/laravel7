<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employees extends Model
{
    public $timestamps = false;
 	protected $table = 'employees';
	
    protected $fillable = ['id',
    'fiest_name',
    'last_name',
    'company_id',
    'email',
    'phone'];
  
    //protected $hidden = ['user_password'];
	
	//use user id of user
	protected $primaryKey = 'id';
}


