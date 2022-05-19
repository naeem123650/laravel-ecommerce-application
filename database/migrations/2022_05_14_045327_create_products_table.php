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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("brand_id");
            $table->string("sku");
            $table->string("name");
            $table->string("slug");
            $table->text("desc")->nullable();
            $table->unsignedInteger("quantity");
            $table->decimal("weight",8,2)->nullable();
            $table->decimal("price",8,2)->nullable();
            $table->decimal("sale_price",8,2)->nullable();
            $table->boolean("status")->default(1);
            $table->boolean("featured")->default(0);
            $table->timestamps();

            $table->foreign("brand_id")->references("id")->on("brands")->onDelete("cascade")->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
