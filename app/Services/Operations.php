<?php

namespace App\Services;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

class Operations
{
    public static function decryptId($value)
    {
        // Check if $value is encrypted
        try {
            $value = Crypt::decrypt($value);
        } catch (DecryptException $e) {
            // If decryption fails, return the original value
            return redirect()->route('home');
        }
        return $value;
    }
}
