<?php

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Storage::exists('countries.json')) {
            $records = json_decode(Storage::get('countries.json'), true);
            foreach ($records['RECORDS'] as $record) {
                Country::create([
                    'code'        => $record['code'],
                    'code_alpha3' => $record['code_alpha3'],
                    'fips_code'   => $record['fips_code'],
                    'name'        => $record['name'],
                    'currency'    => $record['currency'],
                ]);
            }
        }
    }
}
