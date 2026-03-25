<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
    protected $fillable = [
        'original_url',
        'short_code',
        'custom_alias',
        'click_count',
    ];

    public $timestamps = false;

    /**
     * Generate random short code
     */
    public static function generateShortCode(): string
    {
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $code = '';
        $length = random_int(8, 10);
        
        for ($i = 0; $i < $length; $i++) {
            $code .= $chars[random_int(0, strlen($chars) - 1)];
        }

        // Ensure uniqueness
        while (self::where('short_code', $code)->exists()) {
            $code = self::generateShortCode();
        }

        return $code;
    }

    /**
     * Increment click count
     */
    public function incrementClick(): void
    {
        $this->increment('click_count');
    }
}
