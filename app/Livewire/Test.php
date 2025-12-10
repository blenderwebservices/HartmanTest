<?php

namespace App\Livewire;

use Livewire\Component;

class Test extends Component
{
    public $part1Items;
    public $part2Items;
    public $part1Ranking = [];
    public $part2Ranking = [];
    public $currentStep = 1;
    public $guestName = '';

    public function mount()
    {
        $this->part1Items = \App\Models\HvpItem::where('part', 'part_1')->get();
        $this->part2Items = \App\Models\HvpItem::where('part', 'part_2')->get();

        $this->part1Ranking = $this->part1Items->pluck('id')->toArray();
        $this->part2Ranking = $this->part2Items->pluck('id')->toArray();
    }

    public function updateRanking($part, $ranking)
    {
        if ($part === 1) {
            $this->part1Ranking = $ranking;
        } else {
            $this->part2Ranking = $ranking;
        }
    }

    public function nextStep()
    {
        $this->validate([
            'guestName' => 'required|string|max:255',
        ]);

        $this->currentStep = 2;
    }

    public function submit()
    {
        // Calculate scores (placeholder logic for now)
        $scores = [
            'integration' => 0, // Implement actual scoring logic later
        ];

        \App\Models\HvpResult::create([
            'user_id' => auth()->id(),
            'guest_name' => $this->guestName,
            'part_1_ranking' => $this->part1Ranking,
            'part_2_ranking' => $this->part2Ranking,
            'scores' => $scores,
        ]);

        return redirect()->route('filament.admin.pages.dashboard'); // Or a success page
    }

    public function render()
    {
        return view('livewire.test');
    }
}
