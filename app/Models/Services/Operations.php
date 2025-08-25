<?php

namespace App\Services;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class Operations
{
    public static function decryptId($value)
    {
        // Check if $value is encrypted
        try {
            $value = Crypt::decrypt($value);
        } catch (DecryptException $e) {
            return redirect()->route('home')->with('error', 'Invalid note ID.');
        }
        return $value;
    }
}
