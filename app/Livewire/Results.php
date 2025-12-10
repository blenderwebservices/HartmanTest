<?php

namespace App\Livewire;

use Livewire\Component;

class Results extends Component
{
    public \App\Models\HvpResult $result;
    public $part1Normative;
    public $part2Normative;

    public function mount(\App\Models\HvpResult $result)
    {
        $this->result = $result;
        $this->part1Normative = \App\Models\HvpItem::where('part', 'part_1')->pluck('correct_order', 'id')->toArray();
        $this->part2Normative = \App\Models\HvpItem::where('part', 'part_2')->pluck('correct_order', 'id')->toArray();
    }

    public function render()
    {
        return view('livewire.results');
    }
}
