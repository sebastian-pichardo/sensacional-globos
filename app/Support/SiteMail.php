<?php

namespace App\Support;

use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;
use Throwable;

class SiteMail
{
    public static function notify(Mailable $mailable): void
    {
        $to = config('globos.mail.to');

        if (! is_string($to) || $to === '') {
            return;
        }

        try {
            Mail::to($to)->send($mailable);
        } catch (Throwable $e) {
            report($e);
        }
    }
}
