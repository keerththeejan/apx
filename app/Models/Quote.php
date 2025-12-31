<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'subject', 'service_id', 'phone', 'message', 'status', 'notes'
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
