<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Restaurant;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Création des catégories
        $categories = [
            'Française',
            'Espagnole',
            'Africaine',
        ];

        $categoryModels = [];
        foreach ($categories as $categoryName) {
            $categoryModels[$categoryName] = Category::create(['name' => $categoryName]);
        }

        // Création des restaurants
        $restaurants = [
            [
                'nom' => 'Casa Gaia',
                'adresse' => '16 bis Rue Latour, 33000 Bordeaux',
                'note' => 5,
                'latitude' => 44.85053000,
                'longitude' => -0.57109000,
                'category' => 'Française',
            ],
            [
                'nom' => 'Bodega',
                'adresse' => '4 Rue Piliers de Tutelle, 33000 Bordeaux',
                'note' => 2,
                'latitude' => 44.84176000,
                'longitude' => -0.57367000,
                'category' => 'Espagnole',
            ],
            [
                'nom' => 'La Douce Parenthèse',
                'adresse' => '8 bis Rue Maucoudinat, 33000 Bordeaux',
                'note' => 3,
                'latitude' => 44.83904000,
                'longitude' => -0.57096000,
                'category' => 'Française',
            ],
            [
                'nom' => 'Okra',
                'adresse' => '51 Rue Judaïque, 33000 Bordeaux',
                'note' => 4,
                'latitude' => 44.84147000,
                'longitude' => -0.58384000,
                'category' => 'Africaine',
            ],
        ];

        foreach ($restaurants as $restaurantData) {
            $category = $restaurantData['category'];
            unset($restaurantData['category']);

            $restaurant = Restaurant::create($restaurantData);

            // Associer le restaurant à sa catégorie
            if (isset($categoryModels[$category])) {
                $restaurant->categories()->attach($categoryModels[$category]->id);
            }
        }
    }
}
