<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddConfigAndThemeIdToContentPortalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('content_portals', function (Blueprint $table) {
            $table->string('subdomain')->nullable()->after('slug');
            $table->unsignedInteger('content_portal_theme_id')->nullable();
            $table->json('config')->nullable();
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
            $table->dropColumn('content_portal_theme_id');
            $table->dropColumn('config');
            $table->dropColumn('subdomain');
        });
    }
}
