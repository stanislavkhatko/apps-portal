<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInUseToLanguageLineTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('language_lines', function (Blueprint $table) {
            $table->boolean('in_use')->default(false)->after('text');  
            $table->unsignedInteger('content_portal_theme_id')->nullable()->after('id');           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('language_lines', function (Blueprint $table) {
            $table->dropColumn('theme_id');
            $table->dropColumn('in_use');
        });
    }
}
