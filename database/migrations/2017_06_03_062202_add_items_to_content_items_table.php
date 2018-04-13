<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddItemsToContentItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('content_items', function (Blueprint $table) {            
            $table->string('provider')->after('remote_id');
            $table->json('download')->nullable();
            $table->boolean('is_customized')->default(false);            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('content_items', function (Blueprint $table) {
            $table->dropColumn('is_customized');
            $table->dropColumn('provider');
            $table->dropColumn('download');
        });
    }
}
