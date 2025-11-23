<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'profile_photo_path',
        'phone_number',
        'instagram_url',
        'tiktok_url',
        'language',
        'currency',
        'theme',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}