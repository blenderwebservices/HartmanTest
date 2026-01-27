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
            ['en' => 'A baby', 'es' => 'Un bebé', 'rank' => 1, 'dim' => 'intrinsic', 'polarity' => 'comp', 'formula' => 'I^I'],
            ['en' => 'Love of nature', 'es' => 'Amor a la naturaleza', 'rank' => 2, 'dim' => 'intrinsic', 'polarity' => 'comp', 'formula' => 'I^E'],
            ['en' => 'By this ring I thee wed', 'es' => 'Con este anillo te desposo', 'rank' => 3, 'dim' => 'intrinsic', 'polarity' => 'comp', 'formula' => 'I^S'],
            ['en' => 'A devoted scientist', 'es' => 'Un científico devoto', 'rank' => 4, 'dim' => 'extrinsic', 'polarity' => 'comp', 'formula' => 'E^I'],
            ['en' => 'A good meal', 'es' => 'Una buena comida', 'rank' => 5, 'dim' => 'extrinsic', 'polarity' => 'comp', 'formula' => 'E^E'],
            ['en' => 'An assembly line', 'es' => 'Una línea de montaje', 'rank' => 6, 'dim' => 'extrinsic', 'polarity' => 'comp', 'formula' => 'E^S'],
            ['en' => 'A genius', 'es' => 'Un genio', 'rank' => 7, 'dim' => 'systemic', 'polarity' => 'comp', 'formula' => 'S^I'],
            ['en' => 'A technical improvement', 'es' => 'Una mejora técnica', 'rank' => 8, 'dim' => 'systemic', 'polarity' => 'comp', 'formula' => 'S^E'],
            ['en' => 'A uniform', 'es' => 'Un uniforme', 'rank' => 9, 'dim' => 'systemic', 'polarity' => 'comp', 'formula' => 'S^S'],
            
            // Negatives
            ['en' => 'A mathematical system', 'es' => 'Un sistema matemático', 'rank' => 10, 'dim' => 'systemic', 'polarity' => 'trans', 'formula' => 'S_S'],
            ['en' => 'A fine art', 'es' => 'Una obra de arte', 'rank' => 11, 'dim' => 'intrinsic', 'polarity' => 'comp', 'formula' => 'S_E'], // Using S_E slot
            ['en' => 'Blow up an airliner', 'es' => 'Volar un avión de pasajeros', 'rank' => 12, 'dim' => 'systemic', 'polarity' => 'trans', 'formula' => 'S_I'],
            ['en' => 'A slave', 'es' => 'Un esclavo', 'rank' => 13, 'dim' => 'intrinsic', 'polarity' => 'trans', 'formula' => 'E_S'],
            ['en' => 'A rubbish heap', 'es' => 'Un montón de basura', 'rank' => 14, 'dim' => 'extrinsic', 'polarity' => 'trans', 'formula' => 'E_E'],
            ['en' => 'A madman', 'es' => 'Un loco', 'rank' => 15, 'dim' => 'extrinsic', 'polarity' => 'trans', 'formula' => 'E_I'],
            ['en' => 'Burn a heretic', 'es' => 'Quemar a un hereje', 'rank' => 16, 'dim' => 'intrinsic', 'polarity' => 'trans', 'formula' => 'I_S'],
            ['en' => 'Slavery', 'es' => 'Esclavitud', 'rank' => 17, 'dim' => 'intrinsic', 'polarity' => 'trans', 'formula' => 'I_E'],
            ['en' => 'A torture chamber', 'es' => 'Una cámara de tortura', 'rank' => 18, 'dim' => 'intrinsic', 'polarity' => 'trans', 'formula' => 'I_I'],
        ];

        foreach ($part1Items as $item) {
            \App\Models\HvpItem::updateOrCreate(
                ['part' => 'part_1', 'correct_order' => $item['rank']],
                [
                    'content' => ['en' => $item['en'], 'es' => $item['es']],
                    'dimension' => $item['dim'],
                    'polarity' => $item['polarity'],
                    'formula' => $item['formula'],
                ]
            );
        }


        $part2Items = [
            ['en' => 'I like my work', 'es' => 'Me gusta mi trabajo', 'rank' => 1, 'dim' => 'extrinsic', 'polarity' => 'comp', 'formula' => 'I^I'],
            ['en' => 'The universe is a mystery', 'es' => 'El universo es un misterio', 'rank' => 2, 'dim' => 'systemic', 'polarity' => 'comp', 'formula' => 'I^E'],
            ['en' => 'I am a good person', 'es' => 'Soy una buena persona', 'rank' => 3, 'dim' => 'intrinsic', 'polarity' => 'comp', 'formula' => 'I^S'],
            ['en' => 'I am successful', 'es' => 'Soy exitoso', 'rank' => 4, 'dim' => 'extrinsic', 'polarity' => 'comp', 'formula' => 'E^I'],
            ['en' => 'I love my family', 'es' => 'Amo a mi familia', 'rank' => 5, 'dim' => 'intrinsic', 'polarity' => 'comp', 'formula' => 'E^E'],
            ['en' => 'I am happy', 'es' => 'Soy feliz', 'rank' => 6, 'dim' => 'intrinsic', 'polarity' => 'comp', 'formula' => 'E^S'],
            ['en' => 'I am peaceful', 'es' => 'Estoy en paz', 'rank' => 7, 'dim' => 'intrinsic', 'polarity' => 'comp', 'formula' => 'S^I'],
            ['en' => 'I am strong', 'es' => 'Soy fuerte', 'rank' => 8, 'dim' => 'extrinsic', 'polarity' => 'comp', 'formula' => 'S^E'],
            ['en' => 'I am smart', 'es' => 'Soy inteligente', 'rank' => 9, 'dim' => 'systemic', 'polarity' => 'comp', 'formula' => 'S^S'],
            
            // Negatives
            ['en' => 'I am beautiful', 'es' => 'Soy hermoso', 'rank' => 10, 'dim' => 'intrinsic', 'polarity' => 'comp', 'formula' => 'S_S'], // Slot 10
            ['en' => 'I am ugly', 'es' => 'Soy feo', 'rank' => 11, 'dim' => 'intrinsic', 'polarity' => 'trans', 'formula' => 'S_E'],
            ['en' => 'I am stupid', 'es' => 'Soy estúpido', 'rank' => 12, 'dim' => 'systemic', 'polarity' => 'trans', 'formula' => 'S_I'],
            ['en' => 'I am weak', 'es' => 'Soy débil', 'rank' => 13, 'dim' => 'extrinsic', 'polarity' => 'trans', 'formula' => 'E_S'],
            ['en' => 'I am angry', 'es' => 'Estoy enojado', 'rank' => 14, 'dim' => 'intrinsic', 'polarity' => 'trans', 'formula' => 'E_E'],
            ['en' => 'I am sad', 'es' => 'Estoy triste', 'rank' => 15, 'dim' => 'intrinsic', 'polarity' => 'trans', 'formula' => 'E_I'],
            ['en' => 'I am confused', 'es' => 'Estoy confundido', 'rank' => 16, 'dim' => 'systemic', 'polarity' => 'trans', 'formula' => 'I_S'],
            ['en' => 'I am a failure', 'es' => 'Soy un fracaso', 'rank' => 17, 'dim' => 'extrinsic', 'polarity' => 'trans', 'formula' => 'I_E'],
            ['en' => 'I hate myself', 'es' => 'Me odio a mí mismo', 'rank' => 18, 'dim' => 'intrinsic', 'polarity' => 'trans', 'formula' => 'I_I'],
        ];

        foreach ($part2Items as $item) {
            \App\Models\HvpItem::updateOrCreate(
                ['part' => 'part_2', 'correct_order' => $item['rank']],
                [
                    'content' => ['en' => $item['en'], 'es' => $item['es']],
                    'dimension' => $item['dim'],
                    'polarity' => $item['polarity'],
                    'formula' => $item['formula'],
                ]
            );
        }
    }
}
