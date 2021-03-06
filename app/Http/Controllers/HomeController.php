<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\Thread;
use App\Models\Tag;
use App\Models\Banner;

class HomeController extends Controller
{
    public function show(Request $request){
        $thread = Thread::with(['user', 'comments.user'])
            ->where('pinned', 0)
            ->where('sidebar', 0)
            ->where('group_id', 1);
        switch($request->query('tab')){
            case 'week':
                $beg = date('Y-m-d', strtotime('this week'));
                $end = date('Y-m-d', strtotime('next week - 1 day'));
                $thread->whereBetween('created_at', [$beg, $end])
                    ->withCount('favorited')
                    ->orderBy('favorited_count', 'desc');
                break;
            case 'month':
                $beg = date('Y-m-01', strtotime('this week'));
                $end = date('Y-m-d', strtotime('last day of this month'));
                $thread->whereBetween('created_at', [$beg, $end])
                    ->withCount('favorited')
                    ->orderBy('favorited_count', 'desc');
                break;
            case 'year':
                $beg = date('Y-01-01', strtotime('this week'));
                $end = date('Y-12-31', strtotime('next week - 1 day'));
                $thread->whereBetween('created_at', [$beg, $end])
                    ->withCount('favorited')
                    ->orderBy('favorited_count', 'desc');
                break;
            case 'latest':
            default:
                $thread->orderBy('created_at', 'desc');
                break;
        }
        if($request->query('tag_id')){
            $tagid = $request->query('tag_id');
            $thread->whereHas('tags', function($q) use ($tagid){
                $q->where('tag_id', $tagid);
            });
        }
        return Inertia::render('Dashboard', [
            'tab' => $request->query('tab'),
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'threads' => $thread->get(),
            'banners' => Banner::orderBy('created_at', 'desc')
                ->limit(3)
                ->get(),
            'pinned' => Thread::with(['user', 'comments.user'])
                ->orderBy('created_at', 'desc')
                ->where('pinned', 1)
                ->where('sidebar', 0)
                ->where('group_id', 1)
                ->first(),
            'sidebar' => Thread::with(['user', 'comments.user'])
                ->orderBy('created_at', 'desc')
                ->where('pinned', 0)
                ->where('sidebar', 1)
                ->where('group_id', 1)
                ->get(),
            'tags' => Tag::all()
        ]);
    }
}
