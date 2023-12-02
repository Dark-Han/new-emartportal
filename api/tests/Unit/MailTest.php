<?php

namespace Tests\Unit;

use App\Mail\TestMail;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class MailTest extends TestCase
{
    public function testBasic()
    {
        $mail=new TestMail();
        $headers=$mail->headers();
        dd($headers->text);
        $this->assertTrue(true);
    }
}
