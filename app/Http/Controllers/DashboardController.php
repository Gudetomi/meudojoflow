<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Aluno;
use App\Models\Presenca;
use App\Models\Evento;
use App\Models\Turma;
use App\Models\Unidade;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Exibe o dashboard com os principais indicadores.
     */
    public function index()
    {
        $user = Auth::user();

        $totalUnidadesAtivas = Unidade::where('user_id', $user->id)
                                      ->where('ativo', true)
                                      ->count();

        // NOVO: Verifica se a mensagem de boas-vindas deve ser exibida
        $showOnboarding = ($totalUnidadesAtivas === 0);

        // O resto dos cálculos só é necessário se o utilizador já tiver começado
        if (!$showOnboarding) {
            $totalAlunosAtivos = Aluno::where('user_id', $user->id)->where('ativo', true)->count();
            $totalTurmasAtivas = Turma::where('user_id', $user->id)->where('ativo', true)->count();

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
        }

        // Envia todos os dados para a view
        return view('dashboard', [
            'showOnboarding' => $showOnboarding,
            'totalAlunosAtivos' => $totalAlunosAtivos ?? 0,
            'totalTurmasAtivas' => $totalTurmasAtivas ?? 0,
            'totalUnidadesAtivas' => $totalUnidadesAtivas,
            'taxaDePresenca' => $taxaDePresenca ?? 0,
            'proximosEventos' => $proximosEventos ?? collect()
        ]);
    }
}
