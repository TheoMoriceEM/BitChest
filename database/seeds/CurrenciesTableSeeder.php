<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CurrenciesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (config('cryptocurrencies_list') as $api_id => $name) {
            DB::table('currencies')->insert([
                'name'      => $name,
                'logo'      => 'img/' . Str::kebab($name) . '.png',
                'api_id'    => $api_id
            ]);
        }
    }
}
