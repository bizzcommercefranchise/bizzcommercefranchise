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
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('franchise_id')->unsigned()->nullable();   
            $table->foreign('franchise_id')->references('id')->on('franchises')->onDelete('cascade');
            $table->integer('provider_id')->unsigned()->nullable();   
            $table->foreign('provider_id')->references('id')->on('providers')->onDelete('cascade');             
            $table->integer('product_category_id')->unsigned()->nullable();   
            $table->foreign('product_category_id')->references('id')->on('product_categories')->onDelete('cascade');             
            $table->string('name',255);
            $table->decimal('cost',4,2);
            $table->integer('status')->default(1);
            $table->integer('created_by')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->integer('updated_by')->nullable();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
            $table->integer('deleted_by')->nullable();
            $table->timestamp('deleted_at')->nullable()->default(null);
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
