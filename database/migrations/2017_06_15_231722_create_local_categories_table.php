<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocalCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('local_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('provider_category_id')->nullable();
            $table->unsignedInteger('local_content_type_id')->nullable();
            $table->json('label')->nullable();
            $table->boolean('auto_sync_content_items')->default(1);
            $table->boolean('adult')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('local_categories');
    }
}
