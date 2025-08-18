<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Evento;
use Illuminate\Support\Str;
class EventoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $eventos = Evento::where('user_id', Auth::id())->get();
        return view('eventos.index', [
                'eventos' => $eventos,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'data_inicio' => 'required|date',
            'data_fim' => 'nullable|date|after_or_equal:data_inicio',
            'descricao' => 'nullable|string',
            'cor' => 'nullable|string|max:7',
        ], [
            'titulo.required' => 'O título do evento é obrigatório.',
            'data_inicio.required' => 'A data de início do evento é obrigatória.',
            'data_fim.after_or_equal' => 'A data de fim do evento deve ser após ou igual à data de início.',
        ]);

        $evento = Auth::user()->eventos()->create($validated);

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
    }

    /**
     * Display the specified resource.
     */
    public function show(Evento $evento)
    {
        if ($evento->user_id !== Auth::id()) {
            abort(403, 'Acesso não autorizado.');
        }
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
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Evento $evento)
    {
        // Garante que o utilizador só pode editar os seus próprios eventos
        if ($evento->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'data_inicio' => 'required|date',
            'data_fim' => 'nullable|date|after_or_equal:data_inicio',
            'descricao' => 'nullable|string',
            'cor' => 'nullable|string|max:7',
        ]);

        $evento->update($validated);

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
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Evento $evento)
    {
        if ($evento->user_id !== Auth::id()) {
            abort(403);
        }

        $evento->delete();

        return redirect()->route('calendario.index')->with('success', 'Evento excluído com sucesso!');
    }
    public function feed(Request $request)
    {
       $start = $request->query('start');
       $end = $request->query('end');
       $eventos = Evento::where('user_id', Auth::id())
            ->where(function ($query) use ($start, $end) {
                $query->whereBetween('data_inicio', [$start, $end])
                      ->orWhereBetween('data_fim', [$start, $end])
                      ->orWhere(function($q) use ($start, $end) {
                          $q->where('data_inicio', '<=', $start)
                            ->where('data_fim', '>=', $end);
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
    public function gerarLinkCompartilhamento()
    {
        $user = Auth::user();

        if (empty($user->calendario_token)) {
            $user->calendario_token = Str::uuid();
            $user->save();
        }

        $url = route('calendario.publico', ['token' => $user->calendario_token]);
        return response()->json(['url' => $url]);
    }
}
