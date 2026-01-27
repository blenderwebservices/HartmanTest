<?php

namespace App\Livewire;

use Livewire\Component;

class Test2 extends Component
{
    public $part1Items;
    public $part2Items;
    public $part1Ranking = [];
    public $part2Ranking = [];
    public $currentStep = 1;
    public $guestName = '';

    public function mount()
    {
        $this->part1Items = \App\Models\HvpItem::where('part', 'part_1')->get()->map(function($item) {
            return [
                'id' => $item->id,
                'display_content' => $item->getTranslation('content', app()->getLocale()),
                'part' => $item->part,
                'correct_order' => $item->correct_order, // keep if needed, though mostly for backend score calc
            ];
        })->toArray(); // Convert to array to ensure JSON encoding works as expected

        $this->part2Items = \App\Models\HvpItem::where('part', 'part_2')->get()->map(function($item) {
            return [
                'id' => $item->id,
                'display_content' => $item->getTranslation('content', app()->getLocale()),
                'part' => $item->part,
                'correct_order' => $item->correct_order,
            ];
        })->toArray();

        // Since items are now arrays, pluck 'id' from the array
        $this->part1Ranking = array_column($this->part1Items, 'id');
        $this->part2Ranking = array_column($this->part2Items, 'id');
    }

    public function updateRanking($part, $ranking)
    {
        // $ranking is array of IDs in order
        if ($part === 1) {
            $this->part1Ranking = $ranking;
            // Reorder the items collection to match, so UI stays consistent if re-rendered?
            // Actually, for the user's specific Drag Drop UI, the localized JS state matters most.
            // But we need to keep track here.
        } else {
            $this->part2Ranking = $ranking;
        }
    }

    public function nextStep()
    {
        if ($this->currentStep === 1) {
            $this->validate([
                'guestName' => 'required|string|max:255',
            ]);
        }
        
        $this->currentStep++;
    }

    public function submit()
    {
        $part1Scores = \App\Models\HvpResult::calculateProfile($this->part1Ranking, 'part_1');
        $part2Scores = \App\Models\HvpResult::calculateProfile($this->part2Ranking, 'part_2');

        $scores = [
            'part_1' => $part1Scores,
            'part_2' => $part2Scores,
        ];

        $result = \App\Models\HvpResult::create([
            'user_id' => auth()->id(),
            'guest_name' => $this->guestName,
            'part_1_ranking' => $this->part1Ranking,
            'part_2_ranking' => $this->part2Ranking,
            'scores' => $scores,
        ]);

        return redirect()->route('results', ['result' => $result->id]);
    }

    public function render()
    {
        return view('livewire.test2');
    }
}
