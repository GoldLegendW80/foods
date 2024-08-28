<?php

namespace Database\Seeders;

use App\Models\Restaurant;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $restaurants = [
            [
                'nom' => 'Le Petit Bistro',
                'adresse' => '15 Rue de la Paix, 75002 Paris',
                'latitude' => 48.8698,
                'longitude' => 2.3315,
                'type_cuisine' => 'Française',
                'note' => 4,
            ],
            [
                'nom' => 'Sushi Master',
                'adresse' => '8 Avenue des Champs-Élysées, 75008 Paris',
                'latitude' => 48.8729,
                'longitude' => 2.3021,
                'type_cuisine' => 'Japonaise',
                'note' => 5,
            ],
            [
                'nom' => 'La Pizzeria',
                'adresse' => '22 Rue du Faubourg Saint-Antoine, 75012 Paris',
                'latitude' => 48.8515,
                'longitude' => 2.3726,
                'type_cuisine' => 'Italienne',
                'note' => 3,
            ],
            [
                'nom' => 'Le Coq Au Vin',
                'adresse' => '30 Rue Dauphine, 75006 Paris',
                'latitude' => 48.8539,
                'longitude' => 2.3390,
                'type_cuisine' => 'Française',
                'note' => 4,
            ],
            [
                'nom' => 'Chez Léon',
                'adresse' => '24 Rue de la Butte aux Cailles, 75013 Paris',
                'latitude' => 48.8272,
                'longitude' => 2.3530,
                'type_cuisine' => 'Belge',
                'note' => 4,
            ],
        ];

        foreach ($restaurants as $restaurant) {
            Restaurant::create($restaurant);
        }
    }
}
