<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;

class FortuneWheelController extends Controller
{
    public function index()
    {
        $restaurants = Restaurant::all();

        return view('fortune-wheel', compact('restaurants'));
    }
}
