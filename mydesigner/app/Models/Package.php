<?php

namespace MyDesigner\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'package_name', 'amount',
    ];

	//
	public function teams()
	{
	  return $this->belongsToMany(Team::class);
	}
}
