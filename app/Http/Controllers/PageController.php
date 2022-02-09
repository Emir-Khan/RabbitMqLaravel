<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    public function getWelcomePageWithNavBar()
    {
        if (Auth::user()==null) {
            return view("welcome")->with(["user"=>null]);
        }
        return view("welcome")->with(["user"=>Auth::user()]);
    }
}
