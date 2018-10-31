<?php

namespace MyDesigner\Models;

use Illuminate\Database\Eloquent\Model;

class Style extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'style_name', 'type', 'value',
    ];

	public function users()
	{
	  return $this->belongsTo(User::class);
	}

	public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachments');
    }
}
