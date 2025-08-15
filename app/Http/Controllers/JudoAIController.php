<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Gemini\Laravel\Facades\Gemini;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class JudoAIController extends Controller
{
    /**
     * Exibe a página do assistente de IA.
     */
    public function index()
    {
        return view('ia.judo-expert');
    }

    /**
     * Processa a pergunta do utilizador e retorna a resposta da IA.
     */
    public function ask(Request $request): JsonResponse
    {
        // Validação da pergunta
        $request->validate(['pergunta' => 'required|string|max:500']);

        $perguntaDoUtilizador = $request->input('pergunta');

        // Construção do prompt com o contexto da persona "Sensei"
        $prompt = "Você é um assistente especialista em Judô Kodokan. Responda às perguntas
                dos usuários de forma clara, objetiva e informativa. Suas respostas devem focar
                na história, nas regras, na filosofia e na terminologia do judô. Não responda
                a perguntas que fujam deste tópico: \"{$perguntaDoUtilizador}\"";

        try {
            // CORREÇÃO: A sintaxe correta para chamar o modelo Gemini 1.5 Flash
           $result = Gemini::generativeModel('gemini-1.5-flash-latest')
                           ->generateContent($prompt);
            
            return response()->json(['resposta' => $result->text()]);

        } catch (\Exception $e) {
            // Regista o erro detalhado no seu ficheiro de log
            Log::error('Erro na API do Gemini: ' . $e->getMessage());

            // Retorna uma mensagem de erro genérica para o utilizador
            return response()->json(['error' => 'Ocorreu um erro ao comunicar com a IA. Por favor, tente novamente mais tarde.'], 500);
        }
    }
}