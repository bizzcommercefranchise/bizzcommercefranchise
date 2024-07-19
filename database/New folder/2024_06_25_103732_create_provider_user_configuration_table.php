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
        Schema::create('provider_user_configuration', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('provider_user_id')->unsigned()->nullable();   
            $table->foreign('provider_user_id')->references('id')->on('provider_users')->onDelete('cascade');            
            $table->string('configuration',45);
            $table->string('value',45);
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
        Schema::dropIfExists('provider_user_configuration');
    }
};
