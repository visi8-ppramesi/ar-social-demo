<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Thread;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use App\Models\Tag;


class ThreadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $img = $request->file('image');
        $vid = $request->file('video');
        $createObj = [
            'message' => $request['post'],
            'user_id' => auth()->user()->id,
            'group_id' => 1
        ];
        if($img){
            $imgPath = $img->store('public/images');
            $createObj['image'] = Storage::url($imgPath);
        }
        if($vid){
            $vidPath = $vid->store('public/videos');
            $createObj['video'] = Storage::url($vidPath);
        }
        Thread::create($createObj);
        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        return Inertia::render('Post', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'tags' => Tag::all(),
            'thread' => Thread::with(['user', 'comments.user'])
                ->where('id', $request['thread_id'])
                ->first(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function edit(Thread $thread)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Thread $thread)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function destroy(Thread $thread)
    {
        //
    }

    public function like(Thread $thread){
        $uid = auth()->user()->id;
        $tid = $thread->id;
        $fav = Favorite::where([
            ['user_id', '=', $uid],
            ['thread_id', '=', $tid]
        ]);
        if($fav->exists()){
            $fav->delete();
            $thread->decrement('likes');
        }else{
            Favorite::create([
                'user_id' => $uid,
                'thread_id' => $tid
            ]);
            $thread->increment('likes');
        }
        return redirect()->back();
        // return Inertia::render('Dashboard', [
        //     'canLogin' => Route::has('login'),
        //     'canRegister' => Route::has('register'),
        //     'threads' => Thread::with(['user', 'comments'])->orderBy('created_at', 'desc')->get(),
        //     'tags' => Tag::all()
        // ]);
    }
}
