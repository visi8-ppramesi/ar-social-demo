<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\Thread;
use App\Models\Tag;

class HomeController extends Controller
{
    public function show(){

        return Inertia::render('Dashboard', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'threads' => Thread::with(['user', 'comments'])->orderBy('created_at', 'desc')->get(),
            'tags' => Tag::all()
        ]);
    }
}
