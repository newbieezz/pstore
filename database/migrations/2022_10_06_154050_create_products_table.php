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
            $table->integer('section_id');//which section it belongs
            $table->integer('category_id');//which category does it belong
            $table->integer('brand_id');//which brand it is
            $table->integer('vendor_id');//which vendor it belongs
            $table->string('admin_type');
            $table->string('product_name');
            $table->string('product_code');
            $table->string('product_price');
            $table->string('product_discount');
            $table->string('product_image');
            $table->string('product_video');
            $table->string('description');
            $table->string('meta_title');
            $table->string('meta_keywords');
            $table->string('meta_description');
            $table->enum('is_featured',['No','Yes']); //if featured/displayin or not
            $table->tinyInteger('status');//active or inactive
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
