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

    public function generateAiInterpretation($force = false)
    {
        // Si ya existe, no regenerar a menos que sea explícito
        if ($this->aiInterpretation && !$this->isLoadingAi && !$force) {
            return;
        }

        $this->isLoadingAi = true;
        
        try {
            $this->aiInterpretation = $this->result->generateAiInterpretation();
        } finally {
            $this->isLoadingAi = false;
        }
    }

    public function recalculate()
    {
        $this->isLoadingAi = true;
        $this->aiInterpretation = ''; // Limpiar para mostrar loading

        try {
            $this->result->recalculateScores();
            $this->aiInterpretation = $this->result->generateAiInterpretation();
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
            'aiInterpretation' => \App\Models\HvpResult::formatForPdf($this->aiInterpretation),
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
