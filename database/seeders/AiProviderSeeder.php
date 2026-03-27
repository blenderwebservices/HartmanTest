<?php

namespace Database\Seeders;

use App\Models\AiProvider;
use App\Models\AiVendor;
use App\Models\AiModel;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AiProviderSeeder extends Seeder
{
    use WithoutModelEvents;

    const DEFAULT_SYSTEM_PROMPT = 'Eres el asistente de IA del sistema Hartman Test. Tu función es ayudar a los usuarios a comprender su perfil axiológico (valores humanos) basado en la Ciencia de los Valores de Robert S. Hartman. Explica los resultados del test de manera clara, profesional y empática. Puedes responder preguntas sobre:
- Los conceptos del Hartman Value Profile (HVP)
- Los tres tipos de valores: sistémicos (S), extrínsecos (E) e intrínsecos (I)
- La interpretación de los resultados de Parte 1 (El Mundo) y Parte 2 (Yo Mismo)
- El significado de las diferentes combinaciones de valores

IMPORTANTE: Usa formato Markdown para tus respuestas (negritas, listas, encabezados). Cuando uses fórmulas matemáticas, utiliza delimitadores LaTeX: $formula$ para inline o $$formula$$ para bloques.';

    public function run(): void
    {
        if (AiProvider::count() > 0) {
            return;
        }

        $geminiVendor = AiVendor::where('key', 'gemini')->first();
        $geminiModel  = AiModel::where('key', 'gemini-2.5-flash-lite')
            ->where('ai_vendor_id', optional($geminiVendor)->id)
            ->first();

        AiProvider::create([
            'name'               => 'Google Gemini (Default)',
            'ai_vendor_id'       => $geminiVendor?->id,
            'api_key'            => '',
            'ai_model_id'        => $geminiModel?->id,
            'is_default'         => true,
            'web_search_enabled' => false,
            'system_prompt'      => self::DEFAULT_SYSTEM_PROMPT,
        ]);
    }
}
