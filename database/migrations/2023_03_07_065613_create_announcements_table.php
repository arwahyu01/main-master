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
        Schema::create('announcements', function (Blueprint $table) {
            $table->uuid("id")->primary();
			$table->foreignUuid("menu_id")->nullable()->constrained();
			$table->string("title")->nullable();
			$table->date("start")->nullable();
			$table->date("end")->nullable();
			$table->text("content")->nullable();
			$table->string("urgency")->nullable();
			$table->boolean("publish")->nullable();
			$table->foreignUuid("parent_id")->nullable();
			$table->timestamps();
			$table->softDeletes();
        });

        Schema::table('announcements', function (Blueprint $table) {
            $table->foreign("parent_id")->references("id")->on("announcements")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('announcements');
    }
};
