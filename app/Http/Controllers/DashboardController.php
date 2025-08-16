<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Aluno;
use App\Models\Presenca;
use App\Models\Evento;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Exibe o dashboard com os principais indicadores.
     */
    public function index()
    {
        $user = Auth::user();

        // 1. Número de Alunos Ativos
        $totalAlunosAtivos = Aluno::where('user_id', $user->id)
                                  ->where('ativo', true)
                                  ->count();

        // 2. Taxa de Presença (últimos 30 dias)
        $totalPresencasRegistradas = Presenca::where('user_id', $user->id)
                                             ->whereDate('data_presenca', '>=', Carbon::today()->subDays(30))
                                             ->count();
        
        $totalPresentes = Presenca::where('user_id', $user->id)
                                  ->where('presente', true)
                                  ->whereDate('data_presenca', '>=', Carbon::today()->subDays(30))
                                  ->count();

        // Calcula a percentagem, evitando divisão por zero
        $taxaDePresenca = ($totalPresencasRegistradas > 0) 
            ? round(($totalPresentes / $totalPresencasRegistradas) * 100) 
            : 0;
            
        // 3. Próximos Eventos (os 3 mais próximos)
        $proximosEventos = Evento::where('user_id', $user->id)
                                 ->where('data_inicio', '>=', Carbon::today())
                                 ->orderBy('data_inicio', 'asc')
                                 ->take(3)
                                 ->get();

        // 4. Envia todos os dados para a view
        return view('dashboard', [
            'totalAlunosAtivos' => $totalAlunosAtivos,
            'taxaDePresenca' => $taxaDePresenca,
            'proximosEventos' => $proximosEventos
        ]);
    }
}