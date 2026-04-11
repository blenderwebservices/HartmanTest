<?php

namespace App\Livewire;

use Livewire\Component;

class Results extends Component
{
    public \App\Models\HvpResult $result;
    public $part1Normative;
    public $part2Normative;
    public string $aiInterpretation = '';
    public bool $isLoadingAi = false;

    public function mount(\App\Models\HvpResult $result)
    {
        $this->result = $result;
        $this->part1Normative = \App\Models\HvpItem::where('part', 'part_1')->pluck('correct_order', 'id')->toArray();
        $this->part2Normative = \App\Models\HvpItem::where('part', 'part_2')->pluck('correct_order', 'id')->toArray();
        
        // Cargar interpretación si ya existe
        if ($this->result->ai_interpretation) {
            $this->aiInterpretation = $this->result->ai_interpretation;
        }
    }

    public function generateAiInterpretation()
    {
        // Si ya existe, no regenerar a menos que sea explícito (ahorramos tokens)
        if ($this->aiInterpretation && !$this->isLoadingAi) {
            return;
        }

        $this->isLoadingAi = true;
        
        try {
            $agent = new \App\Ai\Agents\ChatAgent();
            $userPrompt = "Por favor, analiza y brinda una interpretación profesional de los siguientes resultados del Test de Hartman: " . json_encode($this->result->scores);
            
            $this->aiInterpretation = (string) $agent->prompt($userPrompt);
            
            // Guardar en la base de datos
            $this->result->update([
                'ai_interpretation' => $this->aiInterpretation
            ]);
        } catch (\Exception $e) {
            $this->aiInterpretation = "Lo sentimos, hubo un error al generar la interpretación: " . $e->getMessage();
        } finally {
            $this->isLoadingAi = false;
        }
    }

    public function downloadPdf()
    {
        if (!$this->aiInterpretation) {
            return;
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.diagnosis', [
            'result' => $this->result,
            'aiInterpretation' => $this->aiInterpretation,
            'date' => now()->format('d/m/Y'),
            'part1Normative' => $this->part1Normative,
            'part2Normative' => $this->part2Normative,
        ]);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, "Diagnostico_Hartman_{$this->result->guest_name}.pdf");
    }

    public function render()
    {
        return view('livewire.results');
    }
}
