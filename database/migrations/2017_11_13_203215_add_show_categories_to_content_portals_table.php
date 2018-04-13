<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddShowCategoriesToContentPortalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('content_portals', function (Blueprint $table) {
            $table->tinyInteger('show_categories')->default(1)->after('content_portal_theme_id');
            $table->text('custom_css')->nullable()->after('config');  
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
            $table->dropColumn('show_categories');
            $table->dropColumn('custom_css');
        });
    }
}
