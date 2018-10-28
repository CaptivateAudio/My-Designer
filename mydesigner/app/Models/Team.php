<?php

namespace MyDesigner\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'team_name',
    ];

	//
	public function users()
	{
	  return $this->belongsToMany(User::class);
	}

	public function packages()
	{
	  return $this->belongsToMany(Package::class);
	}
}
