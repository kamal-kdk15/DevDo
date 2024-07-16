<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccountTypeSeeder extends Seeder
{
    public function run()
    {
        DB::table('account_types')->insert([
            ['type' => 'Developer'],
            ['type' => 'Designer'],
            ['type' => 'Company']
        ]);
    }
}
