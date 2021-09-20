<?php

use App\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);
        \Artisan::call('passport:install --force');
        $validatedData["password"] = bcrypt('12345678');
        $validatedData["email"] = "admin@venusit.com";
        $validatedData["name"] = "Riyad";
        $User = User::create($validatedData);
        Role::create(['name' => 'Admin']);
        $User->assignRole('Admin');
    }
}
