<?php

namespace App\Models\Jobs;

/**
 * This model is an example of how to create a model for a job for redis.
 * Note the Model requires no table to be defined as the job doesn't use a table,
 * but it uses the redis queue for the job.
 */

use Illuminate\Database\Eloquent\Model;

class JobSendEveMail extends Model
{
    //Timestamps
    public $timestamps = true;

    protected $fillable = [
        'sender',
        'recipient',
        'recipient_type',
        'subject',
        'body',
        'created_at',
        'updated_at',
    ];
}
