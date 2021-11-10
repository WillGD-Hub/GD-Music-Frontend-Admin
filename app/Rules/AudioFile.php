<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class AudioFile implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $ext = $value->getClientOriginalExtension();
        return $ext == "m4a" || $ext == "mp3" || $ext == "mp4" || $ext == "mpeg" || $ext == "wav";
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Data :attribute harus bertipe (.m4a), (.mp3), (.mp4), (.mpeg), (.wav)!';
    }
}
