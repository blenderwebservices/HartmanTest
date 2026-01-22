<div class="w-full max-w-6xl mx-auto p-6 text-gray-800">
    
    <!-- Hero -->
    <section class="text-center mb-16">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">{{ __('documentation.title') }}</h1>
        <p class="text-lg text-gray-600 max-w-3xl mx-auto">{{ __('documentation.subtitle') }}</p>
    </section>

    <!-- Fundamentos -->
    <section id="fundamentos" class="mb-16 scroll-mt-20">
        <div class="text-center mb-12">
            <h3 class="text-3xl font-bold mb-2">{{ __('documentation.foundations_title') }}</h3>
            <p class="text-md text-gray-600 max-w-2xl mx-auto">{{ __('documentation.foundations_desc') }}</p>
        </div>
        <div class="grid md:grid-cols-3 gap-8">
            <div class="bg-gray-50 p-6 rounded-lg text-center border border-gray-200">
                <div class="text-4xl mb-4">💖</div>
                <h4 class="text-xl font-bold mb-2 text-blue-500">{{ __('documentation.intrinsic_title') }}</h4>
                <p class="text-gray-600">{{ __('documentation.intrinsic_desc') }}</p>
            </div>
            <div class="bg-gray-50 p-6 rounded-lg text-center border border-gray-200">
                <div class="text-4xl mb-4">🛠️</div>
                <h4 class="text-xl font-bold mb-2 text-green-500">{{ __('documentation.extrinsic_title') }}</h4>
                <p class="text-gray-600">{{ __('documentation.extrinsic_desc') }}</p>
            </div>
            <div class="bg-gray-50 p-6 rounded-lg text-center border border-gray-200">
                <div class="text-4xl mb-4">⚖️</div>
                <h4 class="text-xl font-bold mb-2 text-orange-500">{{ __('documentation.systemic_title') }}</h4>
                <p class="text-gray-600">{{ __('documentation.systemic_desc') }}</p>
            </div>
        </div>
        <div class="mt-12 text-center p-6 bg-gray-50 rounded-lg border border-gray-200">
            <h4 class="text-2xl font-bold mb-2">{{ __('documentation.hierarchy_title') }}</h4>
            <p class="text-gray-600 mb-4">{{ __('documentation.hierarchy_desc') }}</p>
            <div class="flex justify-center items-end space-x-2">
                <div class="p-4 rounded bg-orange-100 border-2 border-orange-500 text-orange-800">{{ __('documentation.hierarchy_s') }}</div>
                <div class="p-6 rounded bg-green-100 border-2 border-green-500 text-green-800">{{ __('documentation.hierarchy_e') }}</div>
                <div class="p-8 rounded bg-blue-100 border-2 border-blue-500 text-blue-800 font-bold">{{ __('documentation.hierarchy_i') }}</div>
            </div>
        </div>
    </section>

    <!-- Formulas -->
    <section id="formulas" class="mb-16 scroll-mt-20">
        <div class="text-center mb-12">
            <h3 class="text-3xl font-bold mb-2">{{ __('documentation.formulas_title') }}</h3>
            <p class="text-md text-gray-600 max-w-2xl mx-auto">{{ __('documentation.formulas_desc') }}</p>
        </div>
        
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @php
                $formulas = [
                    ['id' => 'Ii', 'rank' => 1, 'dim' => 'blue-500'],
                    ['id' => 'Ie', 'rank' => 2, 'dim' => 'blue-500'],
                    ['id' => 'Is', 'rank' => 3, 'dim' => 'blue-500'],
                    ['id' => 'Ei', 'rank' => 4, 'dim' => 'green-500'],
                    ['id' => 'Ee', 'rank' => 5, 'dim' => 'green-500'],
                    ['id' => 'Es', 'rank' => 6, 'dim' => 'green-500'],
                    ['id' => 'Si', 'rank' => 7, 'dim' => 'orange-500'],
                    ['id' => 'Se', 'rank' => 8, 'dim' => 'orange-500'],
                    ['id' => 'Ss', 'rank' => 9, 'dim' => 'orange-500'],
                    ['id' => '-Ss', 'rank' => 10, 'dim' => 'orange-500'],
                    ['id' => '-Se', 'rank' => 11, 'dim' => 'orange-500'],
                    ['id' => '-Si', 'rank' => 12, 'dim' => 'orange-500'],
                    ['id' => '-Es', 'rank' => 13, 'dim' => 'green-500'],
                    ['id' => '-Ee', 'rank' => 14, 'dim' => 'green-500'],
                    ['id' => '-Ei', 'rank' => 15, 'dim' => 'green-500'],
                    ['id' => '-Is', 'rank' => 16, 'dim' => 'blue-500'],
                    ['id' => '-Ie', 'rank' => 17, 'dim' => 'blue-500'],
                    ['id' => '-Ii', 'rank' => 18, 'dim' => 'blue-500']
                ];
            @endphp

            @foreach($formulas as $formula)
                <div class="p-4 bg-gray-50 rounded-lg border-l-4 border-{{ $formula['dim'] }} hover:shadow-md transition-shadow">
                    <div class="flex justify-between items-center">
                        <h5 class="font-bold text-lg">{{ __('documentation.formula_' . $formula['id'] . '_name') }}</h5>
                        <span class="text-xs font-mono px-2 py-1 bg-gray-200 text-gray-700 rounded">{{ $formula['id'] }}</span>
                    </div>
                    <p class="text-sm text-gray-600 mt-1">{{ __('documentation.formula_' . $formula['id'] . '_desc') }}</p>
                    <div class="text-xs mt-2 text-right text-gray-500">{{ __('documentation.normative_rank') }}: <strong>{{ $formula['rank'] }}</strong></div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Variables -->
    <!-- Variables -->
    <section id="variables" class="mb-16 scroll-mt-20">
        <div class="text-center mb-12">
            <h3 class="text-3xl font-bold mb-2">{{ __('documentation.variables_title') }}</h3>
            <p class="text-md text-gray-600 max-w-2xl mx-auto">{{ __('documentation.variables_desc') }}</p>
        </div>
        
        @php
            $categories = [
                [
                    'title' => __('documentation.cat_1_title'),
                    'desc' => __('documentation.cat_1_desc'),
                    'vars' => ['dim_i', 'dim_e', 'dim_s'],
                    'color' => 'blue'
                ],
                [
                    'title' => __('documentation.cat_2_title'),
                    'desc' => __('documentation.cat_2_desc'),
                    'vars' => ['dif', 'dim', 'int', 'dis'],
                    'color' => 'green'
                ],
                [
                    'title' => __('documentation.cat_3_title'),
                    'desc' => __('documentation.cat_3_desc'),
                    'vars' => ['dim_per', 'int_per', 'ai_per'],
                    'color' => 'orange'
                ],
                [
                    'title' => __('documentation.cat_4_title'),
                    'desc' => __('documentation.cat_4_desc'),
                    'vars' => ['vq', 'sq', 'bqr', 'cq', 'rho'],
                    'color' => 'purple'
                ]
            ];
        @endphp

        <div class="space-y-12">
            @foreach($categories as $category)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 bg-{{ $category['color'] }}-50 border-b border-{{ $category['color'] }}-100">
                        <h4 class="text-2xl font-bold text-{{ $category['color'] }}-800 mb-2">{{ $category['title'] }}</h4>
                        <p class="text-{{ $category['color'] }}-700">{{ $category['desc'] }}</p>
                    </div>
                    
                    <div class="grid md:grid-cols-1 lg:grid-cols-2 gap-6 p-6">
                        @foreach($category['vars'] as $var)
                            <div class="p-5 border border-gray-200 rounded-lg bg-gray-50 hover:bg-white hover:shadow-md transition-all">
                                <h5 class="text-lg font-bold text-gray-800 mb-3 border-b pb-2 flex items-center justify-between">
                                    {{ __('documentation.var_' . $var . '_title') }}
                                    <span class="text-xs bg-gray-200 text-gray-600 py-1 px-2 rounded-full font-mono">{{ strtoupper($var) }}</span>
                                </h5>
                                
                                <div class="space-y-3 text-sm">
                                    <div>
                                        <span class="font-bold text-gray-700 block mb-1">Significado:</span>
                                        <p class="text-gray-600">{{ __('documentation.var_' . $var . '_meaning') }}</p>
                                    </div>
                                    
                                    <div class="grid grid-cols-1 gap-2">
                                        <div class="bg-white p-2 rounded border border-gray-100">
                                            <span class="font-bold text-green-600 text-xs uppercase tracking-wider block mb-1">Rango</span>
                                            <p class="text-gray-600">{{ __('documentation.var_' . $var . '_range') }}</p>
                                        </div>
                                        <div class="bg-white p-2 rounded border border-gray-100">
                                            <span class="font-bold text-blue-600 text-xs uppercase tracking-wider block mb-1">Cálculo</span>
                                            <p class="text-gray-600">{{ __('documentation.var_' . $var . '_calc') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Psicosexual -->
    <section id="psicosexual" class="mb-16 bg-gray-100 p-8 rounded-lg">
        <div class="text-center mb-6">
            <h3 class="text-3xl font-bold mb-2">{{ __('documentation.psychosexual_title') }}</h3>
            <p class="text-md text-gray-600 max-w-3xl mx-auto">{{ __('documentation.psychosexual_desc') }}</p>
        </div>
        <div class="max-w-xl mx-auto text-gray-600 text-center">
            <p class="font-semibold text-gray-800 mb-2">{{ __('documentation.conflict_example_title') }}</p>
            <p>{{ __('documentation.conflict_example_desc') }}</p>
            <div class="my-4 p-3 bg-white rounded-md shadow">{{ __('documentation.conflict_item_1') }}</div>
            <p>{{ __('documentation.conflict_connector') }}</p>
            <div class="my-4 p-3 bg-white rounded-md shadow">{{ __('documentation.conflict_item_2') }}</div>
            <p>{{ __('documentation.conflict_conclusion') }} <span class="font-bold text-red-500">{{ __('documentation.conflict_point') }}</span> {{ __('documentation.conflict_conclusion_end') }}</p>
        </div>
    </section>

    <!-- Consideraciones -->
    <section id="consideraciones" class="scroll-mt-20">
        <div class="text-center mb-12">
            <h3 class="text-3xl font-bold mb-2">{{ __('documentation.considerations_title') }}</h3>
            <p class="text-md text-gray-600 max-w-2xl mx-auto">{{ __('documentation.considerations_desc') }}</p>
        </div>
        
        <div class="space-y-4 max-w-4xl mx-auto" x-data="{ active: null }">
            @php
                $considerations = [
                    ['title' => __('documentation.cons_ip_title'), 'content' => __('documentation.cons_ip_content')],
                    ['title' => __('documentation.cons_standards_title'), 'content' => __('documentation.cons_standards_content')],
                    ['title' => __('documentation.cons_privacy_title'), 'content' => __('documentation.cons_privacy_content')],
                    ['title' => __('documentation.cons_disclaimer_title'), 'content' => __('documentation.cons_disclaimer_content')],
                ];
            @endphp

            @foreach($considerations as $index => $item)
                <div class="bg-gray-50 rounded-lg border border-gray-200">
                    <button @click="active = active === {{ $index }} ? null : {{ $index }}" class="w-full flex justify-between items-center p-4 font-bold text-left focus:outline-none">
                        <span>{{ $item['title'] }}</span>
                        <span class="transform transition-transform duration-300" :class="{ 'rotate-180': active === {{ $index }} }">▼</span>
                    </button>
                    <div x-show="active === {{ $index }}" x-collapse class="overflow-hidden">
                        <p class="p-4 pt-0 text-gray-600">{{ $item['content'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
</div>
