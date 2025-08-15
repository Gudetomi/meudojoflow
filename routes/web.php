<?php

use App\Http\Controllers\GraduacaoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TurmaController;
use App\Http\Controllers\UnidadeController;
use App\Http\Controllers\AlunoController;
use App\Http\Controllers\PresencaController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\PublicoController;
use App\Http\Controllers\JudoAIController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check()
        ? redirect('/dashboard')
        : redirect('/login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::resource('unidades', UnidadeController::class);
    Route::resource('turmas', TurmaController::class);
    Route::resource('alunos', AlunoController::class);
    Route::resource('graduacoes', GraduacaoController::class);

    Route::get('/presenca', [PresencaController::class, 'index'])->name('presenca.index');
    Route::get('/presenca/lancamento', [PresencaController::class, 'create'])->name('presenca.create');
    Route::post('/presenca', [PresencaController::class, 'store'])->name('presenca.store');
    Route::get('/presenca/visualizar/{turma}/{data}', [PresencaController::class, 'show'])->name('presenca.show');
    Route::get('/presenca/editar/{turma}/{data}', [PresencaController::class, 'edit'])->name('presenca.edit');
    Route::put('/presenca/{turma}/{data}', [PresencaController::class, 'update'])->name('presenca.update');
    Route::delete('/presenca/{turma}/{data}', [PresencaController::class, 'destroy'])->name('presenca.destroy');

    Route::get('/calendario', [EventoController::class, 'index'])->name('calendario.index');
    Route::get('/calendario/feed', [EventoController::class, 'feed'])->name('calendario.feed');
    Route::post('/calendario/gerar-link', [EventoController::class, 'gerarLinkCompartilhamento'])->name('calendario.gerar-link');
    Route::post('/calendario', [EventoController::class, 'store'])->name('eventos.store');
    Route::put('/calendario/{evento}', [EventoController::class, 'update'])->name('eventos.update');
    Route::delete('/calendario/{evento}', [EventoController::class, 'destroy'])->name('eventos.destroy');

    // Rotas para AJAX
    Route::get('/turmas/por-unidade/{unidade}', [TurmaController::class, 'getByUnidade'])->name('turmas.porUnidade');
    Route::get('/alunos/por-turma/{turma}', [AlunoController::class, 'getAlunosByTurma'])->name('alunos.porTurma');
    
});

Route::get('/sensei-virtual', [JudoAIController::class, 'index'])->name('ia.judo.index');
Route::post('/sensei-virtual/ask', [JudoAIController::class, 'ask'])->name('ia.judo.ask');

Route::get('/calendario/publico/{token}', [PublicoController::class, 'mostrarCalendario'])->name('calendario.publico');
Route::get('/calendario/publico/{token}/feed', [PublicoController::class, 'feed'])->name('calendario.publico.feed');

require __DIR__.'/auth.php';
