<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HvpResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'guest_name',
        'part_1_ranking',
        'part_2_ranking',
        'scores',
    ];

    protected $casts = [
        'part_1_ranking' => 'array',
        'part_2_ranking' => 'array',
        'scores' => 'array',
    ];
    public static function calculateProfile(array $userRanking, string $part)
    {
        $items = \App\Models\HvpItem::where('part', $part)->get()->keyBy('id');
        $deviations = [];
        $totalDeviation = 0;

        foreach ($userRanking as $index => $itemId) {
            $item = $items[$itemId] ?? null;
            if (!$item) continue;

            $userRank = $index + 1;
            $normativeRank = $item->correct_order;
            $deviation = pow($userRank - $normativeRank, 2);
            
            $deviations[$itemId] = [
                'deviation' => $deviation,
                'dimension' => $item->dimension,
            ];
            $totalDeviation += $deviation;
        }

        $dimScores = [
            'intrinsic' => ['sum' => 0, 'count' => 0],
            'extrinsic' => ['sum' => 0, 'count' => 0],
            'systemic' => ['sum' => 0, 'count' => 0],
        ];

        foreach ($deviations as $data) {
            if (isset($dimScores[$data['dimension']])) {
                $dimScores[$data['dimension']]['sum'] += $data['deviation'];
                $dimScores[$data['dimension']]['count']++;
            }
        }

        return [
            'DIF' => $totalDeviation,
            'DIM_I' => $dimScores['intrinsic']['count'] > 0 ? $dimScores['intrinsic']['sum'] / $dimScores['intrinsic']['count'] : 0,
            'DIM_E' => $dimScores['extrinsic']['count'] > 0 ? $dimScores['extrinsic']['sum'] / $dimScores['extrinsic']['count'] : 0,
            'DIM_S' => $dimScores['systemic']['count'] > 0 ? $dimScores['systemic']['sum'] / $dimScores['systemic']['count'] : 0,
        ];
    }
}
