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
        Schema::create('access_groups', function (Blueprint $table) {
            $table->uuid("id")->primary();
			$table->string("name")->nullable();
			$table->string("code")->nullable();
			$table->timestamps();
			$table->softDeletes();
        });

        Schema::table('access_groups', function (Blueprint $table) {
            //isi sesuai kebutuhan
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('access_groups');
    }
};
