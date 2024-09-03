<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TranslationRequest extends Model
{
    use HasFactory;
    protected $attributes = [
        'reason' => ''
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
    public function translation(){
        return $this->belongsTo(Translation::class, 'translation_id'); 
    }
    public function user(){
        return $this->belongsTo(User::class, 'user_id'); 
    }
}
