<?php

use App\Models\ContentPortalTheme;
use Illuminate\Database\Seeder;

class PortalThemeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ContentPortalTheme::create([
            'name' => 'Theme 1',
            'theme_name' => 'apps_theme_1',
        ]);
        ContentPortalTheme::create([
            'name' => 'Theme 2',
            'theme_name' => 'apps_theme_2',
        ]);
    }
}
