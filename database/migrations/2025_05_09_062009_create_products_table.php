<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')->references('id')->on('companys')->onDelete('cascade');
            $table->unsignedBigInteger('product_category_id')->nullable();
            $table->foreign('product_category_id')->references('id')->on('product_categorys')->onDelete('cascade');
            $table->string('name_ka')->nullable();
            $table->string('name_en')->nullable();
            $table->longText('description_ka')->nullable();
            $table->longText('description_en')->nullable();
            $table->string('old_price')->nullable();
            $table->string('price')->nullable();
            $table->string('picture')->nullable();
            $table->string('show_count')->nullable();
            $table->boolean('status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
