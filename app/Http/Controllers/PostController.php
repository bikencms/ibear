<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class PostController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $redirect = '/dashboard/post';
    public function index() {
        return view('dashboard.post.index'); 
    }
    public function add() {
        return view('dashboard.post.add'); 
    }
}
