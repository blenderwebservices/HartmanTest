<div class="w-full max-w-6xl mx-auto p-6">
    <style>
        .clay-card {
            border-radius: 40px;
            background: #ffffff;
            border: 4px solid #ffffff;
            /* Neumorphism / Claymorphism effect based on qcc-ia */
            box-shadow: 20px 20px 40px rgba(0,0,0,0.08), 
                        inset -6px -6px 12px rgba(0,0,0,0.05), 
                        inset 6px 6px 12px rgba(255,255,255,1);
        }

        .markdown-content h1 { font-size: 1.5rem; font-weight: 800; margin-top: 1.5rem; margin-bottom: 0.5rem; }
        .markdown-content h2 { font-size: 1.25rem; font-weight: 700; margin-top: 1.25rem; margin-bottom: 0.5rem; }
        .markdown-content p { margin-bottom: 1rem; line-height: 1.6; color: #4b5563; }
        .markdown-content strong { font-weight: 700; color: #1f2937; }
        .markdown-content ul { list-style-type: disc; margin-left: 1.5rem; margin-bottom: 1rem; }
        .markdown-content li { margin-bottom: 0.5rem; }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <h1 class="text-3xl font-bold mb-8 text-center text-gray-800">{{ __('test.results_title') ?? 'Test Results' }}</h1>

    <div class="grid md:grid-cols-2 gap-8">
        <!-- Part 1 Results -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-xl font-semibold mb-4 text-center">{{ __('test.part_1_title') }}</h2>
            
            <div class="mb-6">
                <canvas id="part1Chart"></canvas>
            </div>

            @php
                $getInterpretation = function($key, $value) {
                    $interpretation = '';
                    $range = '';
                    $color = 'text-gray-600';
                    $key = trim($key);
                    
                    if ($key === 'DIF' || $key === 'VQ' || $key === 'SQ') {
                        $range = '0 - 162';
                         if ($value <= 30) { $interpretation = 'Excelente'; $color = 'text-green-600'; }
                        elseif ($value <= 60) { $interpretation = 'Bueno'; $color = 'text-blue-600'; }
                        elseif ($value <= 90) { $interpretation = 'Regular'; $color = 'text-orange-600'; }
                        else { $interpretation = 'Malo'; $color = 'text-red-600'; }
                    } elseif (in_array($key, ['DIM I', 'DIM E', 'DIM S'])) {
                        $range = '0 - 7'; // Average 0-7? (Total range is 0-54 approx per dim if 6 items). 
                        // Wait, I am calculating averages for DIM I/E/S. 
                        // If average, range is roughly 0-9. Max deviation is 17.
                        // Let's assume standard deviations sum:
                        // Total Dim Sum Range: 0 - (18+17+..13) = approx 90.
                        // For 6 items, max sum = ~50.
                        // Let's stick to the prompt's implied simple ranges or just display value.
                        // For now using 0-7 as placeholder from previous step.
                         if ($value <= 7) { $interpretation = 'Excelente'; $color = 'text-green-600'; }
                        elseif ($value <= 15) { $interpretation = 'Bueno'; $color = 'text-blue-600'; }
                        elseif ($value <= 25) { $interpretation = 'Regular'; $color = 'text-orange-600'; }
                        else { $interpretation = 'Malo'; $color = 'text-red-600'; }
                    } elseif ($key === 'Dim') {
                        $range = '0 - 80'; // Approximate
                        $interpretation = '-';
                    } elseif ($key === 'Int') {
                        $range = '0 - 50'; 
                        $interpretation = '-';
                    } elseif ($key === 'Dis') {
                        $range = '0 - 30'; 
                        if ($value == 0) { $interpretation = 'Perfecto'; $color = 'text-green-600'; }
                        elseif ($value <= 10) { $interpretation = 'Aceptable'; $color = 'text-blue-600'; }
                        else { $interpretation = 'Confusión'; $color = 'text-red-600'; }
                    } elseif (str_contains($key, '%')) {
                        $range = '0 - 100%';
                        $interpretation = '-';
                    } elseif ($key === 'Rho') {
                        $range = '+1.0 a -1.0';
                        if ($value >= 0.8) { $interpretation = 'Excelente'; $color = 'text-green-600'; }
                        elseif ($value >= 0.6) { $interpretation = 'Bueno'; $color = 'text-blue-600'; }
                        else { $interpretation = 'Bajo'; $color = 'text-red-600'; }
                    }
                    
                    return ['range' => $range, 'text' => $interpretation, 'color' => $color];
                };
            @endphp

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 text-center">
                @foreach(['DIF', 'DIM_I', 'DIM_E', 'DIM_S', 'Dim', 'Int', 'Dis', 'DimP', 'IntP', 'AIP', 'Rho'] as $key)
                    @php 
                        $dataKey = $key;
                        if ($key == 'DimP') $dataKey = 'DimP'; // Matches array key
                        // Map labels to array keys if needed
                        $val = $result->scores['part_1'][$dataKey] ?? 0;
                        $displayKey = str_replace('_', ' ', $key);
                        if ($key == 'DimP') $displayKey = 'Dim %';
                        if ($key == 'IntP') $displayKey = 'Int %';
                        if ($key == 'AIP') $displayKey = 'AI %';
                        
                        $meta = $getInterpretation($displayKey, $val);
                    @endphp
                    <div class="p-3 bg-gray-50 rounded-lg">
                        <div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">{{ $displayKey }}</div>
                        <div class="text-2xl font-bold {{ $meta['color'] }} mb-1">
                            {{ is_numeric($val) && floor($val) != $val ? number_format($val, 2) : $val }}
                        </div>
                        <div class="text-xs text-gray-500 mb-1">Rango: {{ $meta['range'] }}</div>
                        <div class="text-sm font-medium {{ $meta['color'] }}">{{ $meta['text'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Part 2 Results -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-xl font-semibold mb-4 text-center">{{ __('test.part_2_title') }}</h2>
            
            <div class="mb-6">
                <canvas id="part2Chart"></canvas>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 text-center">
                @foreach(['DIF', 'DIM_I', 'DIM_E', 'DIM_S', 'Dim', 'Int', 'Dis', 'DimP', 'IntP', 'AIP', 'Rho'] as $key)
                    @php 
                        $dataKey = $key;
                        if ($key == 'DimP') $dataKey = 'DimP'; 
                        
                        $val = $result->scores['part_2'][$dataKey] ?? 0;
                        $displayKey = str_replace('_', ' ', $key);
                        if ($key == 'DimP') $displayKey = 'Dim %';
                        if ($key == 'IntP') $displayKey = 'Int %';
                        if ($key == 'AIP') $displayKey = 'AI %';
                        
                        $meta = $getInterpretation($displayKey, $val);
                    @endphp
                    <div class="p-3 bg-gray-50 rounded-lg">
                        <div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">{{ $displayKey }}</div>
                        <div class="text-2xl font-bold {{ $meta['color'] }} mb-1">
                            {{ is_numeric($val) && floor($val) != $val ? number_format($val, 2) : $val }}
                        </div>
                        <div class="text-xs text-gray-500 mb-1">Rango: {{ $meta['range'] }}</div>
                        <div class="text-sm font-medium {{ $meta['color'] }}">{{ $meta['text'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div wire:init="generateAiInterpretation" class="mt-12 mb-12">
        <div class="clay-card p-8 md:p-12 transition-all duration-500 hover:scale-[1.01]">
            <div class="flex items-center gap-4 mb-8 border-b-2 border-gray-100 pb-6">
                <div class="bg-indigo-600 p-3 rounded-2xl shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="text-2xl font-black text-gray-800 tracking-tight">Interpretación del Agente IA ✨</h3>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Powered by Hartman Intelligence Agent</p>
                </div>
                <div class="flex items-center gap-2">
                    @if($aiInterpretation && !$isLoadingAi)
                        <button wire:click="recalculate" wire:loading.attr="disabled" class="flex items-center gap-2 bg-white border-2 border-indigo-600 text-indigo-600 px-4 py-2 rounded-xl font-bold hover:bg-indigo-50 transition-all active:scale-95 shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" wire:loading.class="animate-spin" wire:target="recalculate">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            Recalcular
                        </button>

                        <button wire:click="downloadPdf" class="flex items-center gap-2 bg-white border-2 border-indigo-600 text-indigo-600 px-4 py-2 rounded-xl font-bold hover:bg-indigo-50 transition-all active:scale-95 shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            Descargar PDF
                        </button>
                    @endif
                </div>
            </div>

            @if($isLoadingAi)
                <div class="flex flex-col items-center justify-center py-12 space-y-4">
                    <div class="w-12 h-12 border-4 border-indigo-600 border-t-transparent rounded-full animate-spin"></div>
                    <p class="text-indigo-600 font-bold animate-pulse">Analizando perfiles axiológicos...</p>
                </div>
            @elseif($aiInterpretation)
                <div 
                    x-data="{ renderMath() { if (window.renderMathInElement) renderMathInElement($el, { delimiters: [ {left: '$$', right: '$$', display: true}, {left: '$', right: '$', display: false} ] }); } }" 
                    x-effect="renderMath(); $nextTick(() => renderMath())"
                    class="markdown-content text-gray-700"
                >
                    {!! Illuminate\Support\Str::markdown($aiInterpretation) !!}
                </div>
            @else
                <div class="text-center py-8 text-gray-400 font-medium italic">
                    Esperando datos para iniciar el análisis...
                </div>
            @endif
        </div>
    </div>

    <div class="mt-8 text-center">
        <a href="{{ route('test3') }}" class="bg-indigo-600 text-white px-6 py-2 rounded-full font-bold shadow-lg hover:bg-indigo-700 transition-all hover:scale-105 active:scale-95 inline-block">
            {{ __('test.retake_test') ?? 'Retake Test' }}
        </a>
    </div>

    <script>
        document.addEventListener('livewire:initialized', () => {
            const part1UserRanking = @json($result->part_1_ranking);
            const part1NormativeMap = @json($part1Normative);
            
            const part2UserRanking = @json($result->part_2_ranking);
            const part2NormativeMap = @json($part2Normative);

            function renderChart(canvasId, userRanking, normativeMap, label) {
                const ctx = document.getElementById(canvasId).getContext('2d');
                const labels = userRanking.map((_, i) => i + 1);
                
                // Map user ranking (item IDs) to their normative ranks
                const normativeData = userRanking.map(id => normativeMap[id]);
                const userData = userRanking.map((_, i) => i + 1); // User rank is just 1, 2, 3... for the items in that order

                // Wait, the chart in the user code plots:
                // X-axis: User Ranking (Item 1, Item 2...)
                // Y-axis: Rank Value
                // Dataset 1: User Rank (1, 2, 3...)
                // Dataset 2: Normative Rank for that item
                
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [
                            {
                                label: 'Tu Ranking',
                                data: userData,
                                backgroundColor: 'rgba(75, 192, 192, 0.6)',
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 1
                            },
                            {
                                label: 'Ranking Normativo',
                                data: normativeData,
                                backgroundColor: 'rgba(229, 115, 115, 0.6)',
                                borderColor: 'rgba(229, 115, 115, 1)',
                                borderWidth: 1
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: { beginAtZero: false, reverse: true, ticks: { stepSize: 1 } }
                        },
                        plugins: {
                            legend: { position: 'top' },
                            title: { display: true, text: label }
                        }
                    }
                });
            }

            renderChart('part1Chart', part1UserRanking, part1NormativeMap, 'Comparación de Ranking - Parte 1');
            renderChart('part2Chart', part2UserRanking, part2NormativeMap, 'Comparación de Ranking - Parte 2');
        });
    </script>
</div>
