<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TurmaController;

Route::get('/turmas/por-unidade/{unidade}', [TurmaController::class, 'getByUnidade']);
