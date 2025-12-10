<div class="w-full max-w-6xl mx-auto p-6">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <h1 class="text-3xl font-bold mb-8 text-center text-gray-800">{{ __('test.results_title') ?? 'Test Results' }}</h1>

    <div class="grid md:grid-cols-2 gap-8">
        <!-- Part 1 Results -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-xl font-semibold mb-4 text-center">{{ __('test.part_1_title') }}</h2>
            
            <div class="mb-6">
                <canvas id="part1Chart"></canvas>
            </div>

            <div class="grid grid-cols-2 gap-4 text-center">
                <div class="p-3 bg-gray-50 rounded-lg">
                    <div class="text-sm text-gray-500">DIF</div>
                    <div class="text-2xl font-bold">{{ $result->scores['part_1']['DIF'] }}</div>
                </div>
                <div class="p-3 bg-gray-50 rounded-lg">
                    <div class="text-sm text-gray-500">DIM I</div>
                    <div class="text-2xl font-bold text-blue-500">{{ number_format($result->scores['part_1']['DIM_I'], 2) }}</div>
                </div>
                <div class="p-3 bg-gray-50 rounded-lg">
                    <div class="text-sm text-gray-500">DIM E</div>
                    <div class="text-2xl font-bold text-green-500">{{ number_format($result->scores['part_1']['DIM_E'], 2) }}</div>
                </div>
                <div class="p-3 bg-gray-50 rounded-lg">
                    <div class="text-sm text-gray-500">DIM S</div>
                    <div class="text-2xl font-bold text-orange-500">{{ number_format($result->scores['part_1']['DIM_S'], 2) }}</div>
                </div>
            </div>
        </div>

        <!-- Part 2 Results -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-xl font-semibold mb-4 text-center">{{ __('test.part_2_title') }}</h2>
            
            <div class="mb-6">
                <canvas id="part2Chart"></canvas>
            </div>

            <div class="grid grid-cols-2 gap-4 text-center">
                <div class="p-3 bg-gray-50 rounded-lg">
                    <div class="text-sm text-gray-500">DIF</div>
                    <div class="text-2xl font-bold">{{ $result->scores['part_2']['DIF'] }}</div>
                </div>
                <div class="p-3 bg-gray-50 rounded-lg">
                    <div class="text-sm text-gray-500">DIM I</div>
                    <div class="text-2xl font-bold text-blue-500">{{ number_format($result->scores['part_2']['DIM_I'], 2) }}</div>
                </div>
                <div class="p-3 bg-gray-50 rounded-lg">
                    <div class="text-sm text-gray-500">DIM E</div>
                    <div class="text-2xl font-bold text-green-500">{{ number_format($result->scores['part_2']['DIM_E'], 2) }}</div>
                </div>
                <div class="p-3 bg-gray-50 rounded-lg">
                    <div class="text-sm text-gray-500">DIM S</div>
                    <div class="text-2xl font-bold text-orange-500">{{ number_format($result->scores['part_2']['DIM_S'], 2) }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-8 text-center">
        <a href="{{ route('test') }}" class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700">
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
