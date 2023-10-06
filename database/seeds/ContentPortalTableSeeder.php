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
            'title' => 'Portal 1',
            'slug' => 'test1',
            'host' => '',
            'domain' => 'adportal.test',
            'languages' => ['en'],
        ]);

        ContentPortal::create([
            'title' => 'Portal 2',
            'slug' => 'test2',
            'host' => '',
            'domain' => 'adportal.test',
            'languages' => ['en'],
        ]);

    }
}
