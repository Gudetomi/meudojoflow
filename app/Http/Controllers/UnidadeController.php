<?php

namespace App\Http\Controllers;

use App\Models\Unidade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UnidadeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $unidades = Unidade::where('user_id',Auth::id())->get();
        return view('unidades.index',compact('unidades'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('unidades.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nome_unidade' => ['required', 'string', 'max:255']
        ]);
        Unidade::create([
            'nome_unidade' => $request->nome_unidade,
            'user_id' => Auth::id()
        ]);
        return redirect()->route('unidades.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Unidade $unidade)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Unidade $unidade)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Unidade $unidade)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function softDelete(Unidade $unidade)
    {
        //
    }
}
