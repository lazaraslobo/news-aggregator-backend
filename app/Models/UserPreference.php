<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPreference extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'type', 'value'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function updateOrInsertPreference($userId, $type, $value)
    {
        return self::updateOrCreate(
            [
                'user_id' => $userId,
                'type' => $type
            ],
            [
                'value' => $value
            ]
        );
    }
}
