<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->truncate();

        Admin::create([
            'name' => "Naeem Memon",
            'email' => "naeemadmin@gmail.com",
            'password' => bcrypt("@Naeem123"), // password
        ]);

        // Admin::factory()->times(5)->create();
    }
}
