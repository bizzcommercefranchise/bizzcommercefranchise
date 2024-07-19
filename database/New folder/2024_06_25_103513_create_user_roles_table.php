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
        Schema::create('user_roles', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable();   
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('provider_id')->unsigned()->nullable();   
            $table->foreign('provider_id')->references('id')->on('providers')->onDelete('cascade');
            $table->integer('role_id')->unsigned()->nullable();   
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
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
        Schema::dropIfExists('user_roles');
    }
};
