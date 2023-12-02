<?php

namespace App\Http\Controllers;

use App\Mail\TestMail;
use Illuminate\Support\Facades\Mail;

class TestController extends Controller
{
    public function index()
    {
        Mail::to('darkhan.dildabekov@sirenltd.com')->send(new TestMail());
        echo 'mail send';
    }
}
