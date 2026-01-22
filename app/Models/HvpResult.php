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
            $deviation = abs($userRank - $normativeRank);
            
            $deviations[$itemId] = [
                'deviation' => $deviation,
                'squared_deviation' => pow($userRank - $normativeRank, 2),
                'dimension' => $item->dimension,
                'normative_rank' => $normativeRank,
            ];
            $totalDeviation += $deviation;
        }

        // --- Categories 2, 3, 4 Calculations ---

        // 1. Dimensions (Category 1 & 2)
        $dimScores = [
            'intrinsic' => 0,
            'extrinsic' => 0,
            'systemic' => 0,
        ];
        
        // Items by rank for easy lookup (1-18)
        $itemsByRank = []; 
        foreach ($deviations as $itemId => $data) {
            $dimScores[$data['dimension']] += $data['deviation'];
            $itemsByRank[$data['normative_rank']] = $data['deviation'];
        }
        
        // Dim Score (Category 2)
        // Identify highest total, subtract other two.
        // Formula: Max - (Sum - Max) = 2*Max - Sum
        $dimValues = array_values($dimScores);
        $maxDim = max($dimValues);
        $sumDims = array_sum($dimValues); // Should equal DIF theoretically if Dimensions covered all items? 
        // Note: DIF is sum of deviations. DIM_I is sum of deviations of intrinsic items.
        // So Sum(DimScores) == DIF.
        // Therefore Dim = Max - (DIF - Max) = 2*Max - DIF.
        $var_Dim = (2 * $maxDim) - $sumDims;

        // Int uses Rows 6, 8, 10
        $var_Int = ($itemsByRank[6] ?? 0) + ($itemsByRank[8] ?? 0) + ($itemsByRank[10] ?? 0);

        // Dis: Confusion between compositions (1-9) and transposures (10-18).
        // Pairs: (1,18), (2,17), ..., (9,10).
        $var_Dis = 0;
        for ($i = 1; $i <= 9; $i++) {
            $devA = $itemsByRank[$i] ?? 0;
            $devB = $itemsByRank[19 - $i] ?? 0;
            $var_Dis += abs($devA - $devB);
        }

        // Percentages (Category 3)
        // Avoid division by zero
        $dif = $totalDeviation > 0 ? $totalDeviation : 1;
        $var_DimP = ($var_Dim / $dif) * 100;
        $var_IntP = ($var_Int / $dif) * 100;

        // AI%: Sum of negatives (Ranks 10-18) / DIF
        $sumNegatives = 0;
        for ($i = 10; $i <= 18; $i++) {
            $sumNegatives += ($itemsByRank[$i] ?? 0);
        }
        $var_AIP = ($sumNegatives / $dif) * 100;

        // Rho (Category 4 - partial)
        // 1 - 6*Sum(D^2) / n(n^2-1)
        // n = 18. n(n^2-1) = 18 * (324 - 1) = 18 * 323 = 5814.
        $sumSquaredDevs = 0;
        foreach ($deviations as $data) {
            $sumSquaredDevs += $data['squared_deviation'];
        }
        $var_Rho = 1 - ((6 * $sumSquaredDevs) / 5814);


        $countI = $items->where('dimension', 'intrinsic')->count();
        $countE = $items->where('dimension', 'extrinsic')->count();
        $countS = $items->where('dimension', 'systemic')->count();

        return [
            'DIF' => $totalDeviation,
            // Averages for DIM I/E/S as displayed before? 
            // Previous code: sum / count.
            // Let's keep them as Averages for the main "Semáforo" display if that's what was used.
            // But the variables section usually uses TOTALS or AVERAGES? 
            // User prompt: "DIF 2647" (Total). "DIM I 116.36" (Average?).
            // 2647 is huge. 18 items max deviation?
            // Max dev for one item is |1-18|=17.
            // Max DIF = Sum of max devs approx 150-200.
            // 2647 in user screenshot suggests Squared Deviations were used OR it's a different scale.
            // My previous squared calculation gave 2647 (in screenshot).
            // User ASKED to switch to standard range (0-162 for absolute).
            // So now the values will be smaller.
            // I should return the AVERAGES for the specific DIM_I keys if that's what the view expects,
            // OR return the SUMS if that's what "Variables" section expects.
            // The view uses `number_format(..., 2)`.
            // Let's return AVERAGES for the original keys to avoid breaking existing view logic?
            // Wait, the "Variables" section (Category 2, 3, 4) usually works with Totals.
            // I will add specific keys for the plain totals if needed, or stick to the convention.
            // The "Dim" calculation used Totals ($dimScores).
            // I will return the Averages for DIM_I/E/S keys as per original code,
            // and add 'Dim_Total_I' etc if needed. 
            // Actually, the user asked to "calcular dichas variables... colocando sus rangos".
            // I'll stick to the existing keys being averages.
            
            'DIM_I' => $countI > 0 ? $dimScores['intrinsic'] / $countI : 0,
            'DIM_E' => $countE > 0 ? $dimScores['extrinsic'] / $countE : 0,
            'DIM_S' => $countS > 0 ? $dimScores['systemic'] / $countS : 0,

            // New Variables
            'Dim' => $var_Dim,
            'Int' => $var_Int,
            'Dis' => $var_Dis,
            'DimP' => $var_DimP,
            'IntP' => $var_IntP,
            'AIP' => $var_AIP,
            'Rho' => $var_Rho,
        ];
    }
}
