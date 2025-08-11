<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Unidade;
class UnidadeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        // Para cada utilizador, cria 3 unidades
        foreach ($users as $user) {
            Unidade::factory(3)->create([
                'user_id' => $user->id,
            ]);
        }
    }
}
