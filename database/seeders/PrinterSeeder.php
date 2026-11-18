<?php

namespace Database\Seeders;

use App\Models\Printer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PrinterSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            ['Nile Print House', 'Cairo', 'Egypt', 'Offset and digital packaging printing with fast turnaround.', 18.50, 100, 6, 4.8, '#a5f3fc'],
            ['Delta Packaging Co.', 'Tanta', 'Egypt', 'Corrugated and rigid boxes at competitive prices.', 14.00, 200, 9, 4.5, '#bbf7d0'],
            ['Gulf Pack Studio', 'Dubai', 'UAE', 'Premium finishes: foil, emboss and soft-touch lamination.', 32.00, 50, 5, 4.9, '#fbcfe8'],
            ['Alex Carton Works', 'Alexandria', 'Egypt', 'Large-run shipping cartons and food packaging.', 11.75, 500, 12, 4.3, '#fde68a'],
            ['Riyadh Box Factory', 'Riyadh', 'Saudi Arabia', 'High-volume custom printed boxes for retail brands.', 21.00, 300, 8, 4.6, '#ddd6fe'],
        ];

        foreach ($rows as [$name, $city, $country, $desc, $price, $min, $lead, $rating, $color]) {
            Printer::updateOrCreate(['slug' => Str::slug($name)], [
                'name' => $name,
                'city' => $city,
                'country' => $country,
                'description' => $desc,
                'price_per_unit' => $price,
                'min_qty' => $min,
                'lead_days' => $lead,
                'rating' => $rating,
                'color' => $color,
            ]);
        }
    }
}
