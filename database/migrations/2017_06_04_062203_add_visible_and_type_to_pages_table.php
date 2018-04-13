<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVisibleAndTypeToPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pages', function (Blueprint $table) { 
            $table->string('lang_code', 2)->after('content_portal_id');
            $table->string('type')->default('dynamic')->after('content_portal_id');
            $table->unsignedInteger('position')->nullable()->after('body');
            $table->boolean('visible')->default(false)->after('body');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn('lang_code');
            $table->dropColumn('type');
            $table->dropColumn('visible');
            $table->dropColumn('position');
        });
    }
}
