<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("slug")->unique();
            $table->text('desc')->nullable();
            $table->unsignedInteger("parent_id")->default(1)->nullable();
            $table->boolean("featured")->default(0);
            $table->boolean("menu")->default(1);
            $table->string("image")->nullable();
            $table->boolean("status")->default(1)->comment("1 = Active , 0 = Inactive");
            $table->timestamps();

            // $table->foreign("parent_id")->references("category_id")->on("categories")->onDelete("cascade")->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
};
