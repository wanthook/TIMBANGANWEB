<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'username'      => 'superuser',
            'password'      => bcrypt('R4ha514'),
            'photo'         => 'superuser',
            'name'          => 'Mas Superuser',
            'email'         => 'taufiq@indahjaya.co.id',
            'type'          => 'ADMIN',
            'created_by'    => '1',
            'updated_by'    => '1',
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s')
                        
        ]);
    }
}
