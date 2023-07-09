<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function show($page)
    {
        $view = 'pages.'.$page;
        return view()->exists($view) ? view($view) : abort(404);
    }
}
