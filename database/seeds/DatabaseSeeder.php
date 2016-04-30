<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(ProductSeederAA::class);
        $this->call(ProductSeederAB::class);
        $this->call(ProductSeederAC::class);
        $this->call(ProductSeederAD::class);
        $this->call(ProductSeederAE::class);
    }
}
