<?php

namespace Database\Seeders;

use App\Models\Admin\Category\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->truncate();

        Category::create([
            "name" => "Root",
            "desc" => "Please Dont Delete Root Category",
            "parent_id" => 0,
            "menu" => 0,
        ]);

        Category::factory()->times(10)->create();
    }
}
