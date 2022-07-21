<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class MainController extends Controller
{
    public function index()
    {
        $csrf = csrf_token();
        $uuid = Str::uuid();
        return Inertia::render('Index', compact('uuid', 'csrf'));
    }
}
