<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    public function index()
    {
        $restaurants = Restaurant::with('categories')->paginate(15);
        $categories = Category::all();

        return view('restaurants.index', compact('restaurants', 'categories'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nom' => 'required',
            'adresse' => 'required',
            'note' => 'required|numeric|min:1|max:5',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'categories' => 'array',
        ]);

        $restaurant = Restaurant::create($validatedData);

        if ($request->has('categories')) {
            $restaurant->categories()->sync($request->categories);
        }

        return redirect()->route('restaurants.index')->with('success', 'Restaurant ajouté avec succès');
    }

    public function update(Request $request, Restaurant $restaurant)
    {
        $validatedData = $request->validate([
            'nom' => 'required',
            'adresse' => 'required',
            'note' => 'required|numeric|min:1|max:5',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'categories' => 'array',
        ]);

        $restaurant->update($validatedData);

        if ($request->has('categories')) {
            $restaurant->categories()->sync($request->categories);
        } else {
            $restaurant->categories()->detach();
        }

        return redirect()->route('restaurants.index')->with('success', 'Restaurant modifié avec succès');
    }

    public function destroy(Restaurant $restaurant)
    {
        $restaurant->delete();

        return response()->json(['success' => true]);
    }

    public function getAll()
    {
        return Restaurant::with('categories')->get();
    }
}
