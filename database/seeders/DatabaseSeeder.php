<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RoleSeeder::class,
        ]);

        $this->call([
            UserSeeder::class,
        ]);

        $this->call([
            ResidenceTypeSeeder::class,
        ]);

        $this->call([
            ContractTypeSeeder::class,
        ]);

        $this->call([
            PaymentMethodSeeder::class,
        ]);

        $this->call([
            ApplicationStatusSeeder::class,
        ]);
    }
}
