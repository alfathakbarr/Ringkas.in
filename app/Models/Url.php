<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
    protected $fillable = [
        'original_url',
        'short_code',
        'custom_alias',
        'deletion_key',
        'click_count',
        'qr_path',
    ];

    protected $casts = [
        'click_count' => 'integer',
    ];

    public static function generateShortCode(): string
    {
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $maxLength = 10;
        $minLength = 8;

        do {
            $length = random_int($minLength, $maxLength);
            $code = '';

            for ($i = 0; $i < $length; $i++) {
                $code .= $chars[random_int(0, strlen($chars) - 1)];
            }
        } while (self::where('short_code', $code)->exists());

        return $code;
    }

    public function incrementClick(): void
    {
        $this->increment('click_count');
    }
}