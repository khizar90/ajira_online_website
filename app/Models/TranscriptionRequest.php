<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TranscriptionRequest extends Model
{
    use HasFactory;
    protected $attributes = [
        'reason' => ''
    ];
    
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function transcription(){
        return $this->belongsTo(Transcription::class, 'transcription_id'); 
    }
    public function user(){
        return $this->belongsTo(User::class, 'user_id'); 
    }
}
