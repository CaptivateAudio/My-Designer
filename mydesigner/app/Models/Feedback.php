<?php

namespace MyDesigner\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'comment', 'version', 'status',
    ];

   	public function user()
	{
	  return $this->belongsTo(User::class);
	}

    public function design()
    {
        return $this->belongsTo(Design::class);
    }

    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachments');
    }
}
