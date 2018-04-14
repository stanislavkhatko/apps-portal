<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentPortalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('content_portals', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('slug');
            $table->string('subdomain')->nullable();
            $table->unsignedInteger('content_portal_theme_id')->nullable();
            $table->tinyInteger('show_categories')->default(1);
            $table->json('config')->nullable();
            $table->text('custom_css')->nullable();
            $table->string('host');
            $table->string('domain');
            $table->json('languages');
            $table->string('default_language', 2)->nullable();
            $table->string('offer_url')->nullable();
            $table->string('exit_url')->nullable();
            $table->json('options')->nullable();
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
        Schema::dropIfExists('content_portals');
    }
}
