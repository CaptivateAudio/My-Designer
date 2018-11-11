<?php

namespace MyDesigner\Models;

use Illuminate\Database\Eloquent\Model;

class Design extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'status', 'details', 'completion_date', 'package_id',
    ];

	public function users()
	{
	  return $this->belongsToMany(User::class)->withPivot('type');
	}

	public function feedback()
    {
        return $this->hasMany(Feedback::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
