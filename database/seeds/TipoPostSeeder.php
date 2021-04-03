<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipo_post')->insert([
            ['nome'=>'Gatinhos', 'descricao'=> 'Animais mais fofos do mundo'],
            ['nome'=>'Paisagens', 'descricao'=> 'Imagens da natureza'],
            ['nome'=>'Outros', 'descricao'=> 'Qualquer outro']
        ]);
    }
}
