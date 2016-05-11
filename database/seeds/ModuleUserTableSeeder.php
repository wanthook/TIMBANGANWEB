<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class ModuleUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('module_user')->insert([
            'user_id'       => '1',
            'module_id'     => '1',
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s')
                        
        ]);
    }
}
