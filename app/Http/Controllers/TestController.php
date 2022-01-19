<?php

namespace App\Http\Controllers;

use App\Jobs\TestJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    public function index()
    {
            /* $users= DB::table("users");
            print_r($users);
            TestJob::dispatch($users->toArray()); */
    }
}
