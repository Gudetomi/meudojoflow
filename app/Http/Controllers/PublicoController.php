<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class PublicoController extends Controller
{
    /**
     * Exibe o calendário público de um utilizador.
     */
    public function mostrarCalendario(string $token)
    {
        $user = User::where('calendario_token', $token)->firstOrFail();
        return view('calendario.publico', ['user' => $user]);
    }

    /**
     * Fornece os eventos para o calendário público.
     */
    public function feed(string $token, Request $request)
    {
        $user = User::where('calendario_token', $token)->firstOrFail();

        $start = $request->query('start');
        $end = $request->query('end');
        $eventos = $user->eventos()
                        ->where(function ($query) use ($start, $end) {
                            $query->where(function ($q) use ($start, $end) {
                                $q->whereNull('data_fim')
                                  ->whereDate('data_inicio', '>=', $start)
                                  ->whereDate('data_inicio', '<=', $end);
                            });
                            $query->orWhere(function ($q) use ($start, $end) {
                                $q->whereNotNull('data_fim')
                                  ->whereDate('data_inicio', '<=', $end)
                                  ->whereDate('data_fim', '>=', $start);
                            });
                        })
                        ->get();

        $formattedEvents = $eventos->map(function ($evento) {
           return [
                'id'    => $evento->id,
                'title' => $evento->titulo,
                'start' => $evento->data_inicio->format('Y-m-d'),
                'end'    => $evento->data_fim ? $evento->data_fim->addDay()->format('Y-m-d') : null,
                'color' => $evento->cor,
                'extendedProps' => [
                    'description' => $evento->descricao,
                ],
            ];
        });

        return response()->json($formattedEvents);
    }
}