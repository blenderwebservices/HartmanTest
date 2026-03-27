<?php

namespace Database\Seeders;

use App\Models\AiModel;
use App\Models\AiVendor;
use Illuminate\Database\Seeder;

class AiSystemSeeder extends Seeder
{
    public function run(): void
    {
        $vendors = [
            'openai' => [
                'name'   => 'OpenAI',
                'models' => [
                    'gpt-4o'           => 'GPT-4o',
                    'gpt-4o-mini'      => 'GPT-4o Mini',
                    'gpt-4-turbo'      => 'GPT-4 Turbo',
                    'gpt-3.5-turbo'    => 'GPT-3.5 Turbo',
                ],
            ],
            'gemini' => [
                'name'   => 'Google Gemini',
                'models' => [
                    'gemini-2.5-flash'      => 'Gemini 2.5 Flash',
                    'gemini-2.5-flash-lite' => 'Gemini 2.5 Flash Lite',
                    'gemini-2.5-pro'        => 'Gemini 2.5 Pro',
                    'gemini-1.5-pro'        => 'Gemini 1.5 Pro',
                    'gemini-1.5-flash'      => 'Gemini 1.5 Flash',
                ],
            ],
            'anthropic' => [
                'name'   => 'Anthropic Claude',
                'models' => [
                    'claude-3-5-sonnet-latest' => 'Claude 3.5 Sonnet',
                    'claude-3-5-haiku-latest'  => 'Claude 3.5 Haiku',
                    'claude-3-opus-latest'     => 'Claude 3 Opus',
                ],
            ],
            'deepseek' => [
                'name'   => 'DeepSeek',
                'models' => [
                    'deepseek-chat'    => 'DeepSeek Chat (V3)',
                    'deepseek-reasoner'=> 'DeepSeek Reasoner (R1)',
                ],
            ],
            'groq' => [
                'name'   => 'Groq',
                'models' => [
                    'llama-3.3-70b-versatile' => 'Llama 3.3 70B Versatile',
                    'mixtral-8x7b-32768'      => 'Mixtral 8x7b',
                ],
            ],
            'ollama' => [
                'name'   => 'Ollama',
                'models' => [
                    'llama3.1' => 'Llama 3.1',
                    'mistral'  => 'Mistral',
                ],
            ],
            'mistral' => [
                'name'   => 'Mistral',
                'models' => [
                    'mistral-large-latest' => 'Mistral Large',
                    'mistral-small-latest' => 'Mistral Small',
                ],
            ],
            'openrouter' => [
                'name'   => 'OpenRouter',
                'models' => [
                    'google/gemini-2.5-flash' => 'Gemini 2.5 Flash (OR)',
                ],
            ],
        ];

        foreach ($vendors as $key => $data) {
            $vendor = AiVendor::firstOrCreate(
                ['key' => $key],
                ['name' => $data['name']]
            );

            foreach ($data['models'] as $modelKey => $modelName) {
                AiModel::firstOrCreate(
                    [
                        'key'          => $modelKey,
                        'ai_vendor_id' => $vendor->id,
                    ],
                    [
                        'name' => $modelName,
                    ]
                );
            }
        }
    }
}
