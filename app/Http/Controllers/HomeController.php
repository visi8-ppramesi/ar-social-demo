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
            'threads' => Thread::with(['user', 'comments.user'])
                ->orderBy('created_at', 'desc')
                ->where('pinned', 0)
                ->where('sidebar', 0)
                ->where('group_id', 1)
                ->get(),
            'pinned' => Thread::with(['user', 'comments.user'])
                ->orderBy('created_at', 'desc')
                ->where('pinned', 1)
                ->where('sidebar', 0)
                ->where('group_id', 1)
                ->first(),
            'sidebad' => Thread::with(['user', 'comments.user'])
                ->orderBy('created_at', 'desc')
                ->where('pinned', 0)
                ->where('sidebar', 1)
                ->where('group_id', 1)
                ->get(),
            'tags' => Tag::all()
        ]);
    }
}
