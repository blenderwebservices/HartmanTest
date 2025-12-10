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
            $this->part1Items = $this->part1Items->sortBy(function ($item) use ($ranking) {
                return array_search($item->id, $ranking);
            })->values();
        } else {
            $this->part2Ranking = $ranking;
            $this->part2Items = $this->part2Items->sortBy(function ($item) use ($ranking) {
                return array_search($item->id, $ranking);
            })->values();
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
        return view('livewire.test');
    }
}
