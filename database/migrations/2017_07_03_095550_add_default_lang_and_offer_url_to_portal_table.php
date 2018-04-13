<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDefaultLangAndOfferUrlToPortalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('content_portals', function (Blueprint $table) {           
            $table->string('default_language', 2)->nullable()->after('languages');
            $table->string('offer_url')->nullable()->after('default_language');
            $table->string('exit_url')->nullable()->after('offer_url');
            $table->dropColumn('domain');            
            $table->dropColumn('disclaimer');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('content_portals', function (Blueprint $table) {
            $table->dropColumn('default_language');
            $table->dropColumn('offer_url');
            $table->dropColumn('exit_url');
        });
    }
}
