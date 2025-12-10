<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HvpItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $part1Items = [
            'A baby',
            'A genius',
            'A uniform',
            'A slave',
            'A fine art',
            'A rubbish heap',
            'A good meal',
            'A technical improvement',
            'A madman',
            'A devoted scientist',
            'By this ring I thee wed',
            'A torture chamber',
            'Love of nature',
            'A mathematical system',
            'Blow up an airliner',
            'Burn a heretic',
            'An assembly line',
            'Slavery',
        ];

        foreach ($part1Items as $index => $content) {
            \App\Models\HvpItem::create([
                'part' => 'part_1',
                'content' => $content,
                'correct_order' => $index + 1, // Placeholder order
            ]);
        }

        $part2Items = [
            'I like my work',
            'The universe is a mystery',
            'I am a good person',
            'I hate myself',
            'I am a failure',
            'I am successful',
            'I love my family',
            'I am confused',
            'I am happy',
            'I am sad',
            'I am angry',
            'I am peaceful',
            'I am strong',
            'I am weak',
            'I am smart',
            'I am stupid',
            'I am beautiful',
            'I am ugly',
        ];

        foreach ($part2Items as $index => $content) {
            \App\Models\HvpItem::create([
                'part' => 'part_2',
                'content' => $content,
                'correct_order' => $index + 1, // Placeholder order
            ]);
        }
    }
}
