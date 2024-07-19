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
        Schema::create('locations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name',255); 
            $table->string('address',255);
            $table->string('city',255);
            $table->string('state',255);
            $table->string('country',255);
            $table->string('postal_code',255);
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
        Schema::dropIfExists('locations');
    }
};
