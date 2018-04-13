<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDownloadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('content_downloads', function (Blueprint $table) {
            $table->increments('id');
            $table->string('msisdn', 12);
            $table->unsignedInteger('subscription_id');
            $table->unsignedInteger('content_item_id');
            $table->json('item')->nullable();
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
        Schema::dropIfExists('content_downloads');
    }
}
