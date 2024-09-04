<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobAplications extends Model
{
    use HasFactory;
    protected $table = 'job_aplications';
    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function job(): BelongsTo
    {
        return $this->belongsTo(Joob::class ,'joob_id');
    }
}
