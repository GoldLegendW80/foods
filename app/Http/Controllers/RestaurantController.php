<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    public function index()
    {
        $restaurants = Restaurant::paginate(6);

        return view('restaurants.dashboard', compact('restaurants'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nom' => 'required|max:255',
            'adresse' => 'required',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'type_cuisine' => 'required|max:255',
            'note' => 'required|integer|min:1|max:5',
        ]);

        Restaurant::create($validatedData);

        return redirect()->route('restaurants.index')->with('success', 'Restaurant ajouté avec succès.');
    }

    public function update(Request $request, Restaurant $restaurant)
    {
        $validatedData = $request->validate([
            'nom' => 'required|max:255',
            'adresse' => 'required',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'type_cuisine' => 'required|max:255',
            'note' => 'required|integer|min:1|max:5',
        ]);

        $restaurant->update($validatedData);

        return redirect()->route('restaurants.index')->with('success', 'Restaurant mis à jour avec succès.');
    }

    public function destroy(Restaurant $restaurant)
    {
        $restaurant->delete();

        return redirect()->route('restaurants.index')->with('success', 'Restaurant supprimé avec succès.');
    }

    public function getAll()
    {
        $restaurants = Restaurant::all();

        return response()->json($restaurants);
    }
}
