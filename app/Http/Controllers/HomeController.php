<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Seat;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $menu = Menu::all();
        $seat = Seat::where('status', 'available')->get();
        return view('home',[
            'menu' => $menu,
            'seat' => $seat
        ]);
    }
}
