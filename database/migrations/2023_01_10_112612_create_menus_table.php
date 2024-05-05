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
        Schema::create('menus', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('parent_id')->nullable();
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->string('code')->nullable();
            $table->string('url')->nullable();
            $table->string('model')->nullable();
            $table->string('icon')->nullable();
            $table->string('type')->default('backend'); // backend|frontend
            $table->boolean('show')->default(true);
            $table->boolean('active')->default(true);
            $table->integer('sort')->default(0);
            $table->boolean('maintenance')->default(false);
            $table->boolean('coming_soon')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('menus', function (Blueprint $table) {
            $table->foreign('parent_id')->references('id')->on('menus')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menus');
    }
};
