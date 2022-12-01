<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $gender = ['male', 'female'];

        for ($i = 0; $i < 100; $i++) {
            $selectedGender = $gender[array_rand($gender)];

            Supplier::create([
                'first_name' => fake()->firstName($selectedGender),
                'last_name' => fake()->lastName('Male'),
                'email' => fake()->safeEmail(),
                'gender' => $selectedGender,
                'phone_number' => fake()->phoneNumber(),
                'home_address' => fake()->streetAddress(),
            ]);
        }
    }
}
