<?php

namespace MyDesigner\Models;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'filename', 'mime', 'filename_original',
    ];

    /**
     * Get all of the owning attachments_type models.
     */
    public function attachments_type()
    {
        return $this->morphTo();
    }
}
