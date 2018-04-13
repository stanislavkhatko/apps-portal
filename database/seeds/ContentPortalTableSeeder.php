<?php

use App\Models\ContentPortal;
use Illuminate\Database\Seeder;

class ContentPortalTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ContentPortal::create([
            'title' => 'nu',
            'host' => 'portal1.be',
            'languages' => ['en'],
        ]);

        ContentPortal::create([
            'title' => 'apps',
            'host' => 'portal2.be',
            'languages' => ['en'],
        ]);

        ContentPortal::create([
            'title' => 'apps',
            'host' => 'portal1.be',
            'languages' => ['en'],
        ]);

        ContentPortal::create([
            'title' => 'test my slug',
            'host' => 'portal1.be',
            'languages' => ['en'],
        ]);
    }
}
