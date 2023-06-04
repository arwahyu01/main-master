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
        Schema::create('faqs', function (Blueprint $table) {
            $table->uuid("id")->primary();
			$table->string("title")->nullable();
			$table->foreignUuid("parent_id")->nullable();
			$table->foreignUuid("menu_id")->nullable();
			$table->text("description")->nullable();
			$table->integer("visitors")->nullable();
			$table->integer("like")->nullable();
			$table->integer("dislike")->nullable();
			$table->boolean("publish")->default(false);
			$table->timestamps();
			$table->softDeletes();
        });

        Schema::table('faqs', function (Blueprint $table) {
            $table->foreign("parent_id")->references("id")->on("faqs")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('faqs');
    }
};
