<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            ['box-mockups', 'Box Mockups', '📦', '#c4b5fd'],
            ['pouch-bag-mockups', 'Pouch & Bag Mockups', '👜', '#fed7aa'],
            ['bottle-mockups', 'Bottle Mockups', '🍾', '#a5f3fc'],
            ['can-jar-mockups', 'Can & Jar Mockups', '🥫', '#bbf7d0'],
            ['tube-mockups', 'Tube Mockups', '🧴', '#fde68a'],
            ['cup-container-mockups', 'Cup & Container Mockups', '☕', '#fecdd3'],
            ['food-packaging', 'Food Packaging Mockups', '🍰', '#fef3c7'],
            ['water-bottle-mockups', 'Water Bottle Mockups', '💧', '#bae6fd'],
            ['gift-boxes', 'Gift Box Mockups', '🎁', '#fbcfe8'],
            ['paper-bag-mockups', 'Paper Bag Mockups', '🛍️', '#fdba74'],
            ['pizza-box-mockups', 'Pizza Box Mockups', '🍕', '#fed7aa'],
            ['supplement-bottle-mockups', 'Supplement Bottle Mockups', '💊', '#e0f2fe'],
            ['mailer-boxes', 'Mailer Boxes', '📮', '#ddd6fe'],
            ['shipping-display', 'Shipping & Display', '🚚', '#d9f99d'],
        ];

        foreach ($rows as [$slug, $name, $icon, $color]) {
            Category::updateOrCreate(['slug' => $slug], compact('name', 'icon', 'color'));
        }
    }
}
