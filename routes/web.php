<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TurmaController;
use App\Http\Controllers\UnidadeController;
use App\Http\Controllers\AlunoController;
use App\Http\Controllers\PresencaController;
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
    Route::resource('presenca', PresencaController::class);

    Route::get('/turmas/por-unidade/{unidade}', [TurmaController::class, 'getByUnidade'])
        ->name('turmas.porUnidade');
    Route::get('/alunos/por-turma/{turma}', [AlunoController::class, 'getAlunosByTurma'])->name('alunos.porTurma');
});

require __DIR__.'/auth.php';
