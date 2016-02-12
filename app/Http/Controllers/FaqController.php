<?php

namespace Artsenal\Http\Controllers;

use Illuminate\Http\Request;
use Artsenal\Http\Requests;
use Artsenal\Http\Controllers\Controller;

class FaqController extends Controller
{
    public function show() {
        return view('faq.faq');
    }
}
