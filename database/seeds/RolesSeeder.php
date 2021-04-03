<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            ['nome'       => 'ROOT', 
            'descricao' => 'Desenvolvedor'],
            ['nome'       => 'ADMIN', 
            'descricao' => 'Administrador'],
            ['nome'        => 'USER', 
            'descricao' => 'Usuario normal']
        ]);
    }
}
