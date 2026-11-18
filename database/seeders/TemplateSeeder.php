<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Template;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TemplateSeeder extends Seeder
{
    public function run(): void
    {
        // category, name, shape, description, w, h, d, color, featured
        $rows = [
            ['box-mockups', 'Tuck End Box', 'box', 'Straight tuck end, the all-round retail box.', 10, 14, 6, '#fbcfe8', true],
            ['box-mockups', 'Pillow Box', 'box', 'Small box for jewelry and favors.', 12, 6, 6, '#fecdd3', false],
            ['box-mockups', 'Perfume Box', 'box', 'Narrow tuck box for 50ml bottles.', 6, 14, 6, '#a5f3fc', true],
            ['box-mockups', 'Serum Box', 'box', 'Slim dropper bottle box.', 4, 12, 4, '#cffafe', false],
            ['pouch-bag-mockups', 'Stand-up Pouch', 'box', 'Flat pouch for snacks and coffee.', 14, 22, 3, '#fed7aa', true],
            ['pouch-bag-mockups', 'Flat Pouch', 'box', 'Three-side seal flat pouch.', 16, 20, 1.5, '#fde68a', false],
            ['bottle-mockups', 'Perfume Bottle', 'bottle', 'Glass bottle with cap.', 6, 14, 6, '#bae6fd', true],
            ['bottle-mockups', 'Juice Bottle', 'bottle', 'Glass juice bottle.', 7, 20, 7, '#fed7aa', false],
            ['can-jar-mockups', 'Soda Can', 'cylinder', 'Standard 330ml can.', 6.6, 12, 6.6, '#fecaca', true],
            ['can-jar-mockups', 'Cream Jar', 'cylinder', 'Cosmetic jar with lid.', 8, 6, 8, '#bbf7d0', false],
            ['can-jar-mockups', 'Coffee Tin', 'cylinder', 'Round tin for coffee and tea.', 10, 14, 10, '#fed7aa', false],
            ['tube-mockups', 'Cosmetic Tube', 'cylinder', 'Squeeze tube for creams.', 3.5, 14, 3.5, '#fde68a', false],
            ['tube-mockups', 'Chip Tube', 'cylinder', 'Cardboard tube for snacks.', 7.5, 24, 7.5, '#fef3c7', false],
            ['cup-container-mockups', 'Coffee Cup', 'cylinder', 'Paper coffee cup.', 8, 10, 8, '#fecdd3', true],
            ['cup-container-mockups', 'Noodle Cup', 'cylinder', 'Instant noodle cup.', 9, 10, 9, '#fde68a', false],
            ['food-packaging', 'Cake Box', 'box', 'Bakery cake box.', 26, 12, 26, '#fde68a', false],
            ['food-packaging', 'Takeaway Box', 'box', 'Folding lunch box.', 16, 9, 12, '#fed7aa', false],
            ['water-bottle-mockups', 'Water Bottle', 'bottle', 'Plastic water bottle.', 7, 22, 7, '#a5f3fc', false],
            ['gift-boxes', 'Rigid Gift Box', 'box', 'Premium rigid box with lift-off lid.', 18, 8, 18, '#f9a8d4', true],
            ['gift-boxes', 'Box With Handle', 'box', 'Carry box with a top handle.', 16, 18, 8, '#fbcfe8', false],
            ['paper-bag-mockups', 'Paper Bag', 'box', 'Shopping paper bag.', 22, 28, 10, '#fdba74', false],
            ['pizza-box-mockups', 'Pizza Box', 'box', 'Corrugated pizza box.', 32, 4, 32, '#fef3c7', false],
            ['supplement-bottle-mockups', 'Supplement Bottle', 'bottle', 'Pill and supplement bottle.', 6, 11, 6, '#e0f2fe', false],
            ['mailer-boxes', 'Classic Mailer Box', 'box', 'Mailer for subscription boxes.', 24, 8, 18, '#c4b5fd', true],
            ['mailer-boxes', 'Slim Mailer Box', 'box', 'Flat mailer for apparel and print.', 30, 5, 22, '#a5b4fc', false],
            ['mailer-boxes', 'Tall Mailer Box', 'box', 'Deep mailer for gift sets.', 20, 14, 14, '#ddd6fe', false],
            ['shipping-display', 'Shipping Carton', 'box', 'Slotted container for e-commerce.', 40, 30, 30, '#bbf7d0', false],
            ['shipping-display', 'Counter Display', 'box', 'Retail countertop display.', 28, 20, 20, '#d9f99d', false],
        ];

        foreach ($rows as [$cat, $name, $shape, $desc, $w, $h, $d, $color, $featured]) {
            Template::updateOrCreate(['slug' => Str::slug($name)], [
                'category_id' => Category::where('slug', $cat)->value('id'),
                'name' => $name,
                'shape' => $shape,
                'description' => $desc,
                'width' => $w,
                'height' => $h,
                'depth' => $d,
                'default_color' => $color,
                'is_featured' => $featured,
            ]);
        }
    }
}
