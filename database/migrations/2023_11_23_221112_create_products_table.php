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
            $table->integer('brand_id');
            $table->integer('category_id');
            $table->integer('subcategory_id');
            $table->string('product_name',150);
            $table->string('product_slug',150);
            $table->string('product_code',200);
            $table->string('product_qty',100);
            $table->string('product_tags',150)->nullable();
            $table->string('prodcut_size',150)->nullable();
            $table->string('prodcut_color',150)->nullable();
            $table->string('selling_price',100);
            $table->string('discount_price',100)->nullable();
            $table->text('short_descp');
            $table->text('long_descp');
            $table->string('product_thambnail',200);
            $table->string('vendor_id',100)->nullable();
            $table->integer('hot_deals')->nullable();
            $table->integer('featured')->nullable();
            $table->integer('special_offer')->nullable();
            $table->integer('special_deals')->nullable();
            $table->integer('status')->default(1);
            $table->timestamps();
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
