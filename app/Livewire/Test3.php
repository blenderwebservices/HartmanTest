<?php

namespace App\Livewire;

use Livewire\Component;

class Test3 extends Component
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
                'formula' => $item->formula,
                'correct_order' => $item->correct_order,
            ];
        })->toArray();

        $this->part2Items = \App\Models\HvpItem::where('part', 'part_2')->get()->map(function($item) {
            return [
                'id' => $item->id,
                'display_content' => $item->getTranslation('content', app()->getLocale()),
                'part' => $item->part,
                'formula' => $item->formula,
                'correct_order' => $item->correct_order,
            ];
        })->toArray();

        $this->part1Ranking = array_column($this->part1Items, 'id');
        $this->part2Ranking = array_column($this->part2Items, 'id');
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
        return view('livewire.test3');
    }
}
