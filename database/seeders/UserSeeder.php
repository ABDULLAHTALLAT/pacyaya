<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(['email' => 'admin@pacyaya.test'], [
            'name' => 'Pacyaya Admin',
            'password' => 'password',
            'role' => 'admin',
        ]);

        User::updateOrCreate(['email' => 'demo@pacyaya.test'], [
            'name' => 'Demo Customer',
            'password' => 'password',
            'role' => 'customer',
        ]);
    }
}
