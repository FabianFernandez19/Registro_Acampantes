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
        // \App\Models\User::factory(10)->create();
        $this->call(RolesSeeder::class);
        $this->call(PermissionsSeeder::class);
        $this->call(RoleHasPermissionsSeeder::class);
        $this->call(RoleHasPermissionsSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(DistritosSeeder::class);

    }
}
