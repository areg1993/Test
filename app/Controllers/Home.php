<?php


namespace App\Controllers;


use App\Core\Auth;
use App\Core\Request;
use App\Models\Task;

class Home extends Controller
{
    public function index(Request $request)
    {
        return view('home', ['x' => 1, 'y' => 6]);
    }

}