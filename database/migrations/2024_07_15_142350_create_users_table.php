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
        Schema::create('users', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('franchise_id')->unsigned()->nullable();   
            $table->integer('primary_provider_id')->unsigned()->nullable();   
            $table->string('first_name',255);
            $table->string('last_name',255);
            $table->string('email',255);
            $table->integer('status')->default(1);
            $table->integer('created_by')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->integer('updated_by')->nullable();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
            $table->integer('deleted_by')->nullable();
            $table->timestamp('deleted_at')->nullable()->default(null); 
            $table->foreign('franchise_id')->references('id')->on('franchises')->onDelete('cascade');            
            $table->foreign('primary_provider_id')->references('id')->on('providers')->onDelete('cascade');       
                        

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
