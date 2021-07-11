<?php

declare(strict_types=1);

namespace Parents\Mails;

use Illuminate\Queue\SerializesModels;

abstract class Mail extends \Illuminate\Mail\Mailable
{
    use SerializesModels;
}
