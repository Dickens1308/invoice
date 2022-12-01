<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $this->call([RolesSeeder::class, CustomerSeeder::class]);

        $user1 = User::factory()->create([
            'name' => 'Dickens Admin',
            'email' => 'dickens.admin@example.com',
        ]);

        Category::factory(10)->create();
        Product::factory(20)->create();

        $user1->assignRole('admin');
        $user1->assignRole('staff');
        $user1->assignRole('user');

        $user2 = User::factory()->create([
            'name' => 'Dickens Staff',
            'email' => 'dickens.staff@example.com',
        ]);

        $user2->assignRole('staff');

        $user3 = User::factory()->create([
            'name' => 'Dickens User',
            'email' => 'dickens.user@example.com',
        ]);

        $user3->assignRole('user');
    }
}
