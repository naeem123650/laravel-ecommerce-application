<?php

namespace Database\Seeders;

use App\Models\Admin\Attributes\AttributeValue;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AttributeValueSeeder extends Seeder
{
    protected $sizes = ["small","medium","large"];

    protected $colors = ["Blue","Yellow","Green","Red"];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       foreach ($this->sizes as  $size) {
            AttributeValue::create([
                "attribute_id" => 1,
                "value" => $size,
                "price" => null,
            ]);
       }

       foreach ($this->colors as  $color) {
            AttributeValue::create([
                "attribute_id" => 2,
                "value" => $color,
                "price" => null,
            ]);
       }
    }
}
