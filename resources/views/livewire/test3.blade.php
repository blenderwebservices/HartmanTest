<div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap');
        
        .test3-container {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
        }

        .item-card {
            transition: transform 0.2s, box-shadow 0.2s;
            cursor: pointer;
            user-select: none;
            position: relative;
        }

        .item-card.sortable-item {
            cursor: grab;
        }

        .item-card.sortable-item:active {
            cursor: grabbing;
        }

        /* Asegura que el elemento que se mueve esté siempre arriba de todo */
        .sortable-chosen {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.4);
            transform: scale(1.05);
            z-index: 9999 !important;
            opacity: 1 !important;
            background-color: #1e293b !important; /* Slate 800 */
        }

        .sortable-ghost {
            opacity: 0.2;
            background: #3b82f6 !important;
            border: 2px dashed #60a5fa !important;
        }

        /* Manejo de capas para el contenedor sticky y el ranking */
        .concepts-sidebar {
            z-index: 10;
        }

        .ranking-area {
            position: relative;
            z-index: 20;
        }

        /* Animación de entrada */
        .list-enter {
            animation: slideIn 0.3s ease-out forwards;
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateX(-10px); }
            to { opacity: 1; transform: translateX(0); }
        }

        .empty-placeholder {
            border: 2px dashed #334155;
            background: rgba(30, 41, 59, 0.5);
        }

        /* Scrollbar estética */
        .custom-scrollbar::-webkit-scrollbar {
            width: 5px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
    </style>

    <div class="test3-container text-gray-800 min-h-screen flex flex-col overflow-x-hidden">
        @if ($currentStep === 1)
            <!-- Step 1: Name Input -->
            <div class="h-[35vh] flex flex-col items-center justify-end p-8 text-center">
                 <h1 class="text-3xl font-bold text-gray-900 mb-2">Test 3 - Perfil Axiológico</h1>
            </div>
            <div class="w-full max-w-md mx-auto bg-white shadow-md rounded-lg p-8 mt-4 border border-slate-200">
                <h2 class="text-2xl font-bold mb-6 text-center text-slate-800">{{ __('test.enter_name') }}</h2>
                <div class="mb-6">
                    <label for="guestName" class="block text-sm font-medium text-slate-700 mb-2">{{ __('test.your_name') }}</label>
                    <input type="text" wire:model="guestName" id="guestName" class="block w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-3 border" placeholder="{{ __('test.enter_name') }}">
                    @error('guestName') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
                <button wire:click="nextStep" class="w-full bg-blue-600 text-white px-4 py-3 rounded-lg hover:bg-blue-700 font-bold shadow-lg transition-colors">
                    Comenzar Parte 1: El Mundo
                </button>
            </div>

        @elseif ($currentStep === 2)
            <!-- Step 2: Part 1 Logic -->
            <div wire:key="step-2" x-data="test3Logic(@js($part1Items), 1)" x-init="init()" class="w-full max-w-6xl mx-auto p-4 md:p-8">
                <header class="mb-8 text-center">
                    <h1 class="text-3xl font-bold text-slate-800">{{ __('test.part_1_title') }}</h1>
                    <p class="text-slate-500 mt-2 text-lg">Haz clic para elegir y <span class="text-blue-600 font-semibold underline">arrastra para reordenar</span> tu ranking.</p>
                </header>

                <div x-show="isComplete" class="mb-8" style="display: none;" x-transition>
                    <button @click="submitStep()" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-xl transition-all shadow-lg transform hover:-translate-y-1 active:scale-95 text-lg">
                        Continuar a Parte 2: "El Yo"
                    </button>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">
                    <!-- Columna de Conceptos Pendientes -->
                    <div class="concepts-sidebar bg-white p-6 rounded-2xl shadow-sm border border-slate-200 sticky top-8">
                        <div class="flex justify-between items-center mb-6">
                            <div>
                                <h2 class="text-xl font-semibold text-slate-700">Conceptos</h2>
                                <p class="text-xs text-slate-400 mt-1">Toca los elementos para clasificarlos</p>
                            </div>
                            <span :class="unrankedItems.length === 0 ? 'bg-green-500 text-white' : 'bg-slate-100 text-slate-600'" class="px-3 py-1 rounded-full text-sm font-medium transition-all" x-text="unrankedItems.length === 0 ? '¡Completado!' : unrankedItems.length + ' pendientes'"></span>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-1 gap-2 max-h-[60vh] overflow-y-auto pr-2 custom-scrollbar">
                            <template x-for="item in unrankedItems" :key="item.id">
                                <div @click="addToRank(item)" class="item-card bg-slate-50 border border-slate-200 p-3 rounded-xl flex items-center gap-3 hover:border-blue-400 hover:bg-blue-50 transition-all list-enter">
                                    <div class="w-6 h-6 rounded-full bg-white border border-slate-200 flex items-center justify-center text-[10px] text-slate-300 font-bold">?</div>
                                    <span class="text-slate-700 text-sm font-medium flex-1 math-content" x-html="item.display_content"></span>
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- Columna de Ranking con Drag & Drop -->
                    <div class="ranking-area bg-slate-900 p-6 rounded-2xl shadow-xl border border-slate-800">
                        <div class="flex justify-between items-center mb-6">
                            <div>
                                <h2 class="text-xl font-semibold text-white">Tu Ranking</h2>
                                <p class="text-xs text-slate-400 mt-1">1 = Más Bueno | 18 = Más Malo</p>
                            </div>
                            <button @click="resetOrder()" class="text-slate-400 hover:text-white text-sm flex items-center gap-1 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                Reiniciar
                            </button>
                        </div>

                        <div x-ref="rankedList" class="space-y-2 min-h-[450px] transition-all relative">
                            <template x-if="rankedItems.length === 0">
                                <div class="empty-placeholder rounded-2xl p-12 text-center text-slate-500 flex flex-col items-center gap-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 opacity-20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                    </svg>
                                    <p class="text-sm font-light">Selecciona conceptos para empezar.<br>Arrastra para reordenar.</p>
                                </div>
                            </template>
                            
                            <template x-for="(item, index) in rankedItems" :key="item.id">
                                <div :data-id="item.id" class="item-card sortable-item bg-slate-800 border border-slate-700 p-3 rounded-xl flex items-center gap-4 hover:border-blue-500 shadow-lg group list-enter">
                                    <div class="w-8 h-8 rounded-lg bg-slate-700 flex items-center justify-center text-white font-bold text-sm group-hover:bg-blue-600 transition-colors" x-text="index + 1"></div>
                                    <span class="text-slate-200 text-sm font-medium flex-1 math-content" x-html="item.display_content"></span>
                                    <div class="flex items-center gap-2">
                                        <div class="cursor-grab p-1 text-slate-600 group-hover:text-slate-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16" />
                                            </svg>
                                        </div>
                                        <button class="remove-btn text-slate-600 hover:text-red-400 active:text-red-500 p-1 transition-colors" @click.stop="removeFromRank($event, item)" @touchend.stop.prevent="removeFromRank($event, item)">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </template>
                        </div>
                        
                        <div x-show="isComplete" class="mt-8" style="display: none;">
                            <button @click="submitStep()" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-xl transition-all shadow-lg transform hover:-translate-y-1 active:scale-95">
                                Continuar a Parte 2: "El Yo"
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        @elseif ($currentStep === 3)
            <!-- Step 3: Part 2 Logic -->
            <div wire:key="step-3" x-data="test3Logic(@js($part2Items), 2)" x-init="init()" class="w-full max-w-6xl mx-auto p-4 md:p-8">
                <header class="mb-8 text-center">
                    <h1 class="text-3xl font-bold text-slate-800">{{ __('test.part_2_title') }}</h1>
                    <p class="text-slate-500 mt-2 text-lg">Haz clic para elegir y <span class="text-blue-600 font-semibold underline">arrastra para reordenar</span> tu ranking.</p>
                </header>

                <div x-show="isComplete" class="mb-8" style="display: none;" x-transition>
                    <button @click="submitFinal()" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-4 rounded-xl transition-all shadow-lg transform hover:-translate-y-1 active:scale-95 text-lg">
                        Finalizar Test
                    </button>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">
                    <!-- Columna de Conceptos Pendientes -->
                    <div class="concepts-sidebar bg-white p-6 rounded-2xl shadow-sm border border-slate-200 sticky top-8">
                        <div class="flex justify-between items-center mb-6">
                            <div>
                                <h2 class="text-xl font-semibold text-slate-700">Conceptos</h2>
                                <p class="text-xs text-slate-400 mt-1">Toca los elementos para clasificarlos</p>
                            </div>
                            <span :class="unrankedItems.length === 0 ? 'bg-green-500 text-white' : 'bg-slate-100 text-slate-600'" class="px-3 py-1 rounded-full text-sm font-medium transition-all" x-text="unrankedItems.length === 0 ? '¡Completado!' : unrankedItems.length + ' pendientes'"></span>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-1 gap-2 max-h-[60vh] overflow-y-auto pr-2 custom-scrollbar">
                            <template x-for="item in unrankedItems" :key="item.id">
                                <div @click="addToRank(item)" class="item-card bg-slate-50 border border-slate-200 p-3 rounded-xl flex items-center gap-3 hover:border-blue-400 hover:bg-blue-50 transition-all list-enter">
                                    <div class="w-6 h-6 rounded-full bg-white border border-slate-200 flex items-center justify-center text-[10px] text-slate-300 font-bold">?</div>
                                    <span class="text-slate-700 text-sm font-medium flex-1 math-content" x-html="item.display_content"></span>
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- Columna de Ranking con Drag & Drop -->
                    <div class="ranking-area bg-slate-900 p-6 rounded-2xl shadow-xl border border-slate-800">
                        <div class="flex justify-between items-center mb-6">
                            <div>
                                <h2 class="text-xl font-semibold text-white">Tu Ranking</h2>
                                <p class="text-xs text-slate-400 mt-1">1 = Más Bueno | 18 = Más Malo</p>
                            </div>
                            <button @click="resetOrder()" class="text-slate-400 hover:text-white text-sm flex items-center gap-1 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                Reiniciar
                            </button>
                        </div>

                        <div x-ref="rankedList" class="space-y-2 min-h-[450px] transition-all relative">
                            <template x-if="rankedItems.length === 0">
                                <div class="empty-placeholder rounded-2xl p-12 text-center text-slate-500 flex flex-col items-center gap-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 opacity-20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                    </svg>
                                    <p class="text-sm font-light">Selecciona conceptos para empezar.<br>Arrastra para reordenar.</p>
                                </div>
                            </template>
                            
                            <template x-for="(item, index) in rankedItems" :key="item.id">
                                <div :data-id="item.id" class="item-card sortable-item bg-slate-800 border border-slate-700 p-3 rounded-xl flex items-center gap-4 hover:border-blue-500 shadow-lg group list-enter">
                                    <div class="w-8 h-8 rounded-lg bg-slate-700 flex items-center justify-center text-white font-bold text-sm group-hover:bg-blue-600 transition-colors" x-text="index + 1"></div>
                                    <span class="text-slate-200 text-sm font-medium flex-1 math-content" x-html="item.display_content"></span>
                                    <div class="flex items-center gap-2">
                                        <div class="cursor-grab p-1 text-slate-600 group-hover:text-slate-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16" />
                                            </svg>
                                        </div>
                                        <button class="remove-btn text-slate-600 hover:text-red-400 active:text-red-500 p-1 transition-colors" @click.stop="removeFromRank($event, item)" @touchend.stop.prevent="removeFromRank($event, item)">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </template>
                        </div>
                        
                        <div x-show="isComplete" class="mt-8" style="display: none;">
                            <button @click="submitFinal()" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-4 rounded-xl transition-all shadow-lg transform hover:-translate-y-1 active:scale-95">
                                Finalizar Test
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Alpine Logic -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('test3Logic', (items, partNum) => ({
                initialItems: [],
                unrankedItems: [],
                rankedItems: [],
                partNumber: partNum,
                sortable: null,

                init() {
                    this.initialItems = items;
                    this.resetOrder();

                    this.$nextTick(() => {
                        this.initSortable();
                    });
                },

                initSortable() {
                    if (this.sortable) this.sortable.destroy();
                    if (!this.$refs.rankedList) return;

                    this.sortable = new Sortable(this.$refs.rankedList, {
                        animation: 150,
                        ghostClass: 'sortable-ghost',
                        chosenClass: 'sortable-chosen',
                        draggable: '.sortable-item',
                        filter: '.remove-btn',
                        preventOnFilter: false,
                        delay: 150,
                        delayOnTouchOnly: true,
                        forceFallback: false,
                        onEnd: (evt) => {
                            const domNodes = Array.from(this.$refs.rankedList.querySelectorAll('.sortable-item'));
                            if(domNodes.length === 0) return;
                            
                            const newOrderedIds = domNodes.map(node => String(node.getAttribute('data-id')));
                            
                            const newRankedArr = [];
                            newOrderedIds.forEach(id => {
                                const item = this.rankedItems.find(i => String(i.id) === id);
                                if (item) newRankedArr.push(item);
                            });
                            
                            this.rankedItems = newRankedArr;
                            this.refreshMathJax();
                        }
                    });
                },

                resetOrder() {
                    // Random initialization
                    this.unrankedItems = this.shuffle([...this.initialItems]);
                    this.rankedItems = [];
                    
                    this.refreshMathJax();
                    this.$nextTick(() => { this.initSortable(); });
                },

                get isComplete() {
                    return this.unrankedItems.length === 0;
                },

                shuffle(array) {
                    const newArr = [...array];
                    for (let i = newArr.length - 1; i > 0; i--) {
                        const j = Math.floor(Math.random() * (i + 1));
                        [newArr[i], newArr[j]] = [newArr[j], newArr[i]];
                    }
                    return newArr;
                },

                addToRank(item) {
                    this.unrankedItems = this.unrankedItems.filter(i => i.id !== item.id);
                    this.rankedItems.push(item);
                    this.refreshMathJax();
                },

                removeFromRank(event, item) {
                    if(event) event.stopPropagation();
                    
                    this.rankedItems = this.rankedItems.filter(i => i.id !== item.id);
                    this.unrankedItems.push(item);
                    this.refreshMathJax();
                },

                refreshMathJax() {
                    this.$nextTick(() => {
                        if (window.renderMathInElement) {
                           document.querySelectorAll('.math-content').forEach(el => {
                                renderMathInElement(el, {
                                    delimiters: [
                                        {left: '$$', right: '$$', display: true},
                                        {left: '$', right: '$', display: false}
                                    ],
                                    throwOnError: false
                                });
                           });
                        }
                    });
                },

                getFinalRanking() {
                    return this.rankedItems.map(i => i.id);
                },

                submitStep() {
                    if (!this.isComplete) return;
                    const ranking = this.getFinalRanking();
                    this.$wire.updateRanking(this.partNumber, ranking).then(() => {
                         this.$wire.nextStep();
                    });
                },

                submitFinal() {
                    if (!this.isComplete) return;
                    const ranking = this.getFinalRanking();
                    this.$wire.updateRanking(this.partNumber, ranking).then(() => {
                        this.$wire.submit();
                    });
                }
            }));
        });
    </script>
</div>
