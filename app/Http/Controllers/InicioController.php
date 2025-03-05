<?php

namespace App\Http\Controllers;

use App\Models\Post;

class InicioController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        return view('posts/index', compact('posts'));
    }

    public function verWelcome()
    {
        return view('welcome');
    }
}
