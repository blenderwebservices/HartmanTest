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
            transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease, all 0.5s ease;
            aspect-ratio: 2 / 1;
            /* Allow vertical scrolling but prevent horizontal for swipe gestures if needed, 
               though pan-y is better than none for list scrolling */
            touch-action: pan-y; 
            
            /* Prevent native callouts/menus on long press */
            -webkit-touch-callout: none !important;
            -webkit-user-select: none !important;
            -khtml-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none !important;
            
            /* Remove tap highlight color */
            -webkit-tap-highlight-color: transparent;
        }
        .selected {
            border-color: #3b82f6;
            background-color: #eff6ff;
            z-index: 10;
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
            font-size: 0.8rem;
            font-weight: bold;
            pointer-events: none;
        }
        .position-badge {
            position: absolute;
            top: 2.5rem;
            right: 0.5rem;
            background-color: #10b981;
            color: white;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            font-weight: bold;
            pointer-events: none;
        }
        .dragging {
            opacity: 0.5;
            transform: scale(0.95);
        }
        .drag-over {
            border-style: dashed;
            border-color: #3b82f6;
            background-color: #f0f7ff;
        }
        
        /* Specific fix for dragging class if polyfill adds it differently */
        .dnd-poly-drag-image {
            opacity: 0.8 !important;
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
                        Arrastra los cuadros para ordenarlos del 1 al 18 según tu preferencia. El número de orden se actualiza automáticamente según la posición donde sueltes cada cuadro.
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
                                 :class="`formula-card relative border-2 rounded-xl bg-white flex items-center justify-center cursor-pointer select-none ${item.isSelected ? 'selected border-blue-500 shadow-sm' : 'border-gray-200'}`">
                                
                                <div class="text-lg md:text-xl font-medium pointer-events-none p-4 text-center">
                                    <span x-text="item.display_content"></span>
                                </div>
                                
                                <template x-if="item.isSelected">
                                    <div class="number-badge" x-text="item.randomIndex + 1"></div>
                                </template>
                                
                                <!-- Physical position badge removed as it might confuse with the new rules -->
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
                        Arrastra los cuadros para ordenarlos del 1 al 18 según tu preferencia. El número de orden se actualiza automáticamente según la posición donde sueltes cada cuadro.
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
                                 :class="`formula-card relative border-2 rounded-xl bg-white flex items-center justify-center cursor-pointer select-none ${item.isSelected ? 'selected border-blue-500 shadow-sm' : 'border-gray-200'}`">
                                
                                <div class="text-lg md:text-xl font-medium pointer-events-none p-4 text-center">
                                    <span x-text="item.display_content"></span>
                                </div>
                                
                                <template x-if="item.isSelected">
                                    <div class="number-badge" x-text="item.randomIndex + 1"></div>
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
                partNumber: partNum,
                justDragged: false,
                sortable: null,

                init() {
                    this.items = items;
                    this.resetOrder();

                    this.$nextTick(() => {
                        this.initSortable();
                    });
                },

                initSortable() {
                    if (this.sortable) this.sortable.destroy();
                    if (!this.$refs.grid) return;

                    this.sortable = new Sortable(this.$refs.grid, {
                        animation: 150,
                        ghostClass: 'dragging',
                        draggable: '.formula-card',
                        delay: 50,
                        delayOnTouchOnly: true,
                        onEnd: (evt) => {
                            if (evt.oldIndex === evt.newIndex) return;

                            const list = this.sortedAppItems;
                            const source = list[evt.oldIndex];
                            const target = list[evt.newIndex];

                            if (!source || !target) return;

                            // Rule 2.a: Swap positions
                            const tempIdx = source.randomIndex;
                            source.randomIndex = target.randomIndex;
                            target.randomIndex = tempIdx;

                            // Swap selection status
                            const tempSelected = source.isSelected;
                            source.isSelected = target.isSelected;
                            target.isSelected = tempSelected;

                            this.refreshMathJax();
                            
                            this.justDragged = true;
                            setTimeout(() => { this.justDragged = false; }, 300);
                        }
                    });
                },

                resetOrder() {
                    const indices = this.shuffle(Array.from({length: this.items.length}, (_, i) => i));
                    
                    this.appItems = this.items.map((item, index) => ({
                        id: item.id,
                        display_content: item.display_content,
                        formula: item.formula,
                        isSelected: false, 
                        randomIndex: indices[index]
                    }));
                    
                    this.refreshMathJax();
                },

                get sortedAppItems() {
                    return [...this.appItems].sort((a, b) => a.randomIndex - b.randomIndex);
                },

                get numSelected() {
                    return this.appItems.filter(i => i.isSelected).length;
                },

                get isComplete() {
                    return this.numSelected === this.items.length;
                },

                shuffle(array) {
                    const newArr = [...array];
                    for (let i = newArr.length - 1; i > 0; i--) {
                        const j = Math.floor(Math.random() * (i + 1));
                        [newArr[i], newArr[j]] = [newArr[j], newArr[i]];
                    }
                    return newArr;
                },

                handleClick(id) {
                    if (this.justDragged) return;
                    
                    const item = this.appItems.find(i => i.id == id);
                    if (!item) return;

                    if (item.isSelected) {
                        // Rule update: if selected, unselect and swap with the highest-positioned selected item
                        const n = this.numSelected;
                        const list = this.sortedAppItems;
                        const lastSelected = list[n - 1]; // Selected item with the "highest position"

                        if (lastSelected && lastSelected.id !== item.id) {
                            const tempIdx = item.randomIndex;
                            item.randomIndex = lastSelected.randomIndex;
                            lastSelected.randomIndex = tempIdx;
                        }
                        item.isSelected = false;
                    } else {
                        // Original logic for selecting
                        const n = this.numSelected; 
                        const list = this.sortedAppItems;
                        const itemAtTarget = list[n]; // First unselected position

                        if (itemAtTarget && itemAtTarget.id !== item.id) {
                            const tempIdx = item.randomIndex;
                            item.randomIndex = itemAtTarget.randomIndex;
                            itemAtTarget.randomIndex = tempIdx;
                        }
                        item.isSelected = true;
                    }

                    this.refreshMathJax();
                },

                refreshMathJax() {
                    this.$nextTick(() => {
                        if (window.MathJax && window.MathJax.typesetPromise) {
                           MathJax.typesetPromise();
                        }
                    });
                },

                getFinalRanking() {
                    return this.sortedAppItems.map(i => i.id);
                },

                submitStep() {
                    const ranking = this.getFinalRanking();
                    this.$wire.updateRanking(this.partNumber, ranking).then(() => {
                         this.$wire.nextStep();
                    });
                },

                submitFinal() {
                    const ranking = this.getFinalRanking();
                    this.$wire.updateRanking(this.partNumber, ranking).then(() => {
                        this.$wire.submit();
                    });
                }
            }));
        });
    </script>
</div>
