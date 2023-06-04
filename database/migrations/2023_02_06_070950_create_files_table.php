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
        Schema::create('files', function (Blueprint $table) {
            $table->uuid("id")->primary();
			$table->uuidMorphs("fileable");
			$table->string("alias")->nullable();
			$table->json("data")->nullable();
			$table->timestamps();
			$table->softDeletes();
        });

        Schema::table('files', function (Blueprint $table) {
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
        Schema::dropIfExists('files');
    }
};
