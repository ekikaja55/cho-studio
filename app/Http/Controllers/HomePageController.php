<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gallery;

class HomePageController extends Controller
{
    public function index()
    {
        $designs = Gallery::where('status', '!=', 'draft')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('home', compact('designs'));
    }
}
