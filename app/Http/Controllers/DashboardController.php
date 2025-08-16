<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Aluno;
use App\Models\Presenca;
use App\Models\Evento;
use App\Models\Turma;   // Adicionado
use App\Models\Unidade; // Adicionado
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Exibe o dashboard com os principais indicadores.
     */
    public function index()
    {
        $user = Auth::user();

        $totalAlunosAtivos = Aluno::where('user_id', $user->id)
                                  ->where('ativo', true)
                                  ->count();
        
        $totalTurmasAtivas = Turma::where('user_id', $user->id)
                                  ->where('ativo', true)
                                  ->count();

        $totalUnidadesAtivas = Unidade::where('user_id', $user->id)
                                      ->where('ativo', true)
                                      ->count();

        $totalPresencasRegistradas = Presenca::where('user_id', $user->id)
                                             ->whereDate('data_presenca', '>=', Carbon::today()->subDays(30))
                                             ->count();
        
        $totalPresentes = Presenca::where('user_id', $user->id)
                                  ->where('presente', true)
                                  ->whereDate('data_presenca', '>=', Carbon::today()->subDays(30))
                                  ->count();

        $taxaDePresenca = ($totalPresencasRegistradas > 0) 
            ? round(($totalPresentes / $totalPresencasRegistradas) * 100) 
            : 0;
            
        $proximosEventos = Evento::where('user_id', $user->id)
                                 ->where('data_inicio', '>=', Carbon::today())
                                 ->orderBy('data_inicio', 'asc')
                                 ->take(3)
                                 ->get();

        return view('dashboard', [
            'totalAlunosAtivos' => $totalAlunosAtivos,
            'totalTurmasAtivas' => $totalTurmasAtivas,
            'totalUnidadesAtivas' => $totalUnidadesAtivas,
            'taxaDePresenca' => $taxaDePresenca,
            'proximosEventos' => $proximosEventos
        ]);
    }
}