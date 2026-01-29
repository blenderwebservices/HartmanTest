<div>
    <!-- MathJax Config -->
    <script>
        window.MathJax = {
            tex: { inlineMath: [['$', '$']] },
            svg: { fontCache: 'global' }
        };
    </script>
    <script type="text/javascript" id="MathJax-script" async
        src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-svg.js">
    </script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>

    <style>
        .formula-card {
            aspect-ratio: 2 / 1;
            transition: border-color 0.2s, background-color 0.2s;
            /* Evita que el navegador realice scroll accidental al intentar arrastrar */
            touch-action: none; 
            -webkit-tap-highlight-color: transparent;
        }
        .selected {
            border-color: #3b82f6;
            background-color: #eff6ff;
        }
        .number-badge {
            position: absolute;
            top: 0.5rem;
            right: 0.5rem;
            background-color: #3b82f6;
            color: white;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: bold;
            pointer-events: none;
        }
        .sortable-ghost {
            opacity: 0.2;
            background-color: #dbeafe;
        }
        .sortable-chosen {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            transform: scale(1.05);
        }
        /* Clase para indicar que se está detectando un "hold" en móvil */
        .sortable-drag {
            opacity: 1 !important;
        }
    </style>

    <div class="bg-gray-50 text-gray-800 min-h-screen flex flex-col overflow-x-hidden">
        @if ($currentStep === 1)
            <!-- Step 1: Name Input -->
            <div class="h-[35vh] flex flex-col items-center justify-end p-8 text-center">
                 <h1 class="text-3xl font-bold text-gray-900 mb-2">Test 3 - Perfil Axiológico</h1>
            </div>
            <div class="w-full max-w-md mx-auto bg-white shadow-md rounded-lg p-8 mt-4">
                <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">{{ __('test.enter_name') }}</h2>
                <div class="mb-6">
                    <label for="guestName" class="block text-sm font-medium text-gray-700 mb-2">{{ __('test.your_name') }}</label>
                    <input type="text" wire:model="guestName" id="guestName" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-3 border" placeholder="{{ __('test.enter_name') }}">
                    @error('guestName') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
                <button wire:click="nextStep" class="w-full bg-indigo-600 text-white px-4 py-3 rounded-lg hover:bg-indigo-700 font-bold shadow transition-colors">
                    {{ __('test.next_part') }}
                </button>
            </div>

        @elseif ($currentStep === 2)
            <!-- Step 2: Part 1 Logic -->
            <div wire:key="step-2" x-data="test3Logic(@js($part1Items), 1)" x-init="init()" class="w-full h-full flex flex-col">
                <div class="h-[35vh] flex flex-col items-center justify-end p-6 text-center">
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">{{ __('test.part_1_title') }}</h1>
                    <p class="text-gray-600 max-w-lg mb-4 text-sm md:text-base">
                        Tap para numerar. Mantén presionado brevemente para arrastrar e intercambiar.
                    </p>
                    <div class="flex gap-2">
                        <button @click="resetOrder()" class="text-xs bg-white border border-gray-300 px-4 py-2 rounded-full hover:bg-gray-50 transition-all shadow-sm active:scale-95">
                            Reiniciar Posiciones
                        </button>
                    </div>

                    <div x-show="isComplete" class="animate-bounce mt-4">
                        <button @click="submitStep()" class="bg-indigo-600 text-white px-6 py-2 rounded-lg font-bold shadow-lg hover:bg-indigo-700 transition">
                            {{ __('test.next_part') }}
                        </button>
                    </div>
                </div>

                <div class="w-full max-w-5xl mx-auto px-4 pb-20">
                    <div x-ref="grid" id="formula-grid" class="grid grid-cols-2 md:grid-cols-3 gap-3 md:gap-4">
                        <template x-for="item in sortedAppItems" :key="item.id">
                            <div :data-id="item.id"
                                 @click="handleClick(item.id)"
                                 :class="`formula-card relative border-2 rounded-xl bg-white flex items-center justify-center cursor-pointer select-none ${item.order !== null ? 'selected border-blue-500 shadow-sm' : 'border-gray-200'}`">
                                
                                <div class="text-lg md:text-xl font-medium pointer-events-none p-4 text-center">
                                    <span x-text="item.display_content"></span>
                                </div>
                                
                                <template x-if="item.order !== null">
                                    <div class="number-badge" x-text="item.order"></div>
                                </template>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

        @elseif ($currentStep === 3)
            <!-- Step 3: Part 2 Logic -->
            <div wire:key="step-3" x-data="test3Logic(@js($part2Items), 2)" x-init="init()" class="w-full h-full flex flex-col">
                <div class="h-[35vh] flex flex-col items-center justify-end p-6 text-center">
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">{{ __('test.part_2_title') }}</h1>
                    <p class="text-gray-600 max-w-lg mb-4 text-sm md:text-base">
                        Tap para numerar. Mantén presionado brevemente para arrastrar e intercambiar.
                    </p>
                    <div class="flex gap-2">
                        <button @click="resetOrder()" class="text-xs bg-white border border-gray-300 px-4 py-2 rounded-full hover:bg-gray-50 transition-all shadow-sm active:scale-95">
                            Reiniciar Posiciones
                        </button>
                    </div>

                    <div x-show="isComplete" class="animate-bounce mt-4">
                        <button @click="submitFinal()" class="bg-green-600 text-white px-6 py-2 rounded-lg font-bold shadow-lg hover:bg-green-700 transition">
                            {{ __('test.submit_test') }}
                        </button>
                    </div>
                </div>

                <div class="w-full max-w-5xl mx-auto px-4 pb-20">
                    <div x-ref="grid" id="formula-grid-2" class="grid grid-cols-2 md:grid-cols-3 gap-3 md:gap-4">
                        <template x-for="item in sortedAppItems" :key="item.id">
                            <div :data-id="item.id"
                                 @click="handleClick(item.id)"
                                 :class="`formula-card relative border-2 rounded-xl bg-white flex items-center justify-center cursor-pointer select-none ${item.order !== null ? 'selected border-blue-500 shadow-sm' : 'border-gray-200'}`">
                                
                                <div class="text-lg md:text-xl font-medium pointer-events-none p-4 text-center">
                                    <span x-text="item.display_content"></span>
                                </div>
                                
                                <template x-if="item.order !== null">
                                    <div class="number-badge" x-text="item.order"></div>
                                </template>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Alpine Logic -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('test3Logic', (items, partNum) => ({
                items: [],
                appItems: [],
                currentMaxOrder: 0,
                partNumber: partNum,
                sortableInstance: null,

                init() {
                    this.items = items;
                    this.resetOrder();

                    this.$nextTick(() => {
                        this.initSortable();
                    });
                },

                initSortable() {
                    if (!this.$refs.grid) return;
                    if (this.sortableInstance) this.sortableInstance.destroy();

                    this.sortableInstance = new Sortable(this.$refs.grid, {
                        animation: 300,
                        delay: 150,
                        delayOnTouchOnly: true,
                        touchStartThreshold: 5,
                        ghostClass: 'sortable-ghost',
                        chosenClass: 'sortable-chosen',
                        dragClass: 'sortable-drag',
                        onEnd: (evt) => {
                            if (evt.oldIndex === evt.newIndex) return;
                            this.handleLogicSwap(evt.oldIndex, evt.newIndex);
                        }
                    });
                },

                resetOrder() {
                    this.currentMaxOrder = 0;
                    const indices = this.shuffle(Array.from({length: this.items.length}, (_, i) => i));
                    
                    this.appItems = this.items.map((item, index) => ({
                        id: item.id,
                        display_content: item.display_content,
                        formula: item.formula,
                        order: null,
                        randomIndex: indices[index]
                    }));
                    
                    this.refreshMathJax();
                },

                get sortedAppItems() {
                    return [...this.appItems].sort((a, b) => {
                        if (a.order !== null && b.order !== null) return a.order - b.order;
                        if (a.order !== null) return -1;
                        if (b.order !== null) return 1;
                        return a.randomIndex - b.randomIndex;
                    });
                },

                get isComplete() {
                    return this.currentMaxOrder === this.items.length && this.appItems.every(i => i.order !== null);
                },

                shuffle(array) {
                    for (let i = array.length - 1; i > 0; i--) {
                        const j = Math.floor(Math.random() * (i + 1));
                        [array[i], array[j]] = [array[j], array[i]];
                    }
                    return array;
                },

                handleClick(id) {
                    let visualList = this.sortedAppItems;
                    const itemIndex = visualList.findIndex(i => i.id == id);
                    const target = visualList[itemIndex];

                    if (target.order === null) {
                        // RANK IT: Assign next number and shift to its physical position
                        this.currentMaxOrder++;
                        target.order = this.currentMaxOrder;
                        
                        // Move it to index currentMaxOrder - 1 (the end of the ranked section)
                        const item = visualList.splice(itemIndex, 1)[0];
                        visualList.splice(this.currentMaxOrder - 1, 0, item);
                    } else {
                        // UNRANK IT: Remove number and shift to start of unranked section
                        const removedOrder = target.order;
                        target.order = null;
                        
                        // Decrement others
                        visualList.forEach(i => {
                            if (i.order !== null && i.order > removedOrder) {
                                i.order--;
                            }
                        });
                        this.currentMaxOrder--;
                        
                        // Move it after the last ranked item
                        const item = visualList.splice(itemIndex, 1)[0];
                        visualList.splice(this.currentMaxOrder, 0, item);
                    }
                    
                    // Synchronize physical order via randomIndex
                    visualList.forEach((item, index) => {
                        item.randomIndex = index;
                    });
                    
                    this.refreshMathJax();
                },

                handleLogicSwap(oldIndex, newIndex) {
                    let visualList = this.sortedAppItems;
                    const sourceItem = visualList[oldIndex];
                    const targetItem = visualList[newIndex];
                    
                    const isSourceRanked = sourceItem.order !== null;
                    const droppedInRankedZone = newIndex < this.currentMaxOrder;

                    if (!isSourceRanked && droppedInRankedZone) {
                        // RULE: Unranked to Ranked Zone -> INSERT / SHIFT
                        // Assign the rank of the drop position, shift subsequent ranked items
                        const moved = visualList.splice(oldIndex, 1)[0];
                        visualList.splice(newIndex, 0, moved);
                        this.currentMaxOrder++;
                        
                        // Sync randomIndex immediately for the re-rank loop
                        visualList.forEach((item, index) => {
                            item.randomIndex = index;
                        });
                    } else {
                        // RULE: "Conmutar" (Swap) physical positions for other cases
                        // Includes Ranked -> Ranked and Ranked -> Unranked
                        const tempIdx = sourceItem.randomIndex;
                        sourceItem.randomIndex = targetItem.randomIndex;
                        targetItem.randomIndex = tempIdx;
                    }
                    
                    // Re-calculate ranks based on new physical positions
                    setTimeout(() => {
                        const updatedList = this.sortedAppItems;
                        updatedList.forEach((item, index) => {
                            if (index < this.currentMaxOrder) {
                                item.order = index + 1;
                            } else {
                                item.order = null;
                            }
                            // Normalize indices
                            item.randomIndex = index;
                        });
                        this.refreshMathJax();
                    }, 0);
                },

                swapPos(a, b) {
                    const temp = a.randomIndex;
                    a.randomIndex = b.randomIndex;
                    b.randomIndex = temp;
                },
                
                refreshMathJax() {
                    this.$nextTick(() => {
                        if (window.MathJax && window.MathJax.typesetPromise) {
                           MathJax.typesetPromise();
                        }
                    });
                },

                getFinalRanking() {
                    return [...this.appItems]
                        .sort((a, b) => a.order - b.order)
                        .map(i => i.id);
                },

                submitStep() {
                    const ranking = this.getFinalRanking();
                    $wire.updateRanking(this.partNumber, ranking).then(() => {
                         $wire.nextStep();
                    });
                },

                submitFinal() {
                    const ranking = this.getFinalRanking();
                    $wire.updateRanking(this.partNumber, ranking).then(() => {
                        $wire.submit();
                    });
                }
            }));
        });
    </script>
</div>
