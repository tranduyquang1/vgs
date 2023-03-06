<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function video(Request $request)
    {
        $items = Post::latest('published_at_display')->published()->video()->take(3)->get();
        return view('frontend.pages.index.sections.ajax-video', compact('items'));
    }
}
