<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class ModuleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //DB::table('module')->truncate();
        
        DB::table('module')->insert([
            'nama'          => 'Dashboard',
            'desc'          => 'Dashboard',
            'route'         => '#',
//            'param'         => 'Mas Superuser',
            'parent'        => '0',
            'order'         => '0',
            'selected'      => 'dashboard',
            'icon'          => 'iconfa-laptop',
            'created_by'    => '1',
            'updated_by'    => '1',
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s')
                        
        ]);
    }
}
