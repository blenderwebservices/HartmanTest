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
                        Tap para numerar. Mantén presionado brevemente para arrastrar e intercambiar. Al hacer clic en un cuadro sin número, los cuadros numerados se reorganizarán automáticamente.
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
                    <template x-if="showGrid">
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
                                
                                <!-- Physical position badge -->
                                <div class="position-badge" x-text="sortedAppItems.findIndex(i => i.id === item.id) + 1"></div>
                            </div>
                        </template>
                    </div>
                    </template>
                </div>
            </div>

        @elseif ($currentStep === 3)
            <!-- Step 3: Part 2 Logic -->
            <div wire:key="step-3" x-data="test3Logic(@js($part2Items), 2)" x-init="init()" class="w-full h-full flex flex-col">
                <div class="h-[35vh] flex flex-col items-center justify-end p-6 text-center">
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">{{ __('test.part_2_title') }}</h1>
                    <p class="text-gray-600 max-w-lg mb-4 text-sm md:text-base">
                        Tap para numerar. Mantén presionado brevemente para arrastrar e intercambiar. Al hacer clic en un cuadro sin número, los cuadros numerados se reorganizarán automáticamente.
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
                    <template x-if="showGrid">
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
                                
                                <!-- Physical position badge -->
                                <div class="position-badge" x-text="sortedAppItems.findIndex(i => i.id === item.id) + 1"></div>
                            </div>
                        </template>
                    </div>
                    </template>
                </div>
            </div>
        @endif
    </div>

    <!-- Alpine Logic -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('test3Logic', (items, partNum) => ({
                items: [], // Original items from DB
                appItems: [], // Local state
                currentMaxOrder: 0,
                draggedId: null,
                partNumber: partNum,
                justDragged: false, // Flag to prevent click after drag
                showGrid: true, // For nuclear DOM reset
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
                        delay: 50,
                        delayOnTouchOnly: true,
                        onEnd: (evt) => {
                            if (evt.oldIndex === evt.newIndex) return;

                            const list = this.sortedAppItems;
                            const sourceItem = list[evt.oldIndex];
                            const targetItem = list[evt.newIndex];

                            if (!sourceItem || !targetItem) return;

                            this.handleSortableDrop(sourceItem.id, targetItem.id);
                            
                            this.justDragged = true;
                            setTimeout(() => { this.justDragged = false; }, 300);
                        }
                    });
                },

                // ... (resetOrder, sortedAppItems, isComplete, shuffle, handleClick stay same)
                
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
                    return [...this.appItems].sort((a, b) => a.randomIndex - b.randomIndex);
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
                    if (this.justDragged) return;
                    
                    const target = this.appItems.find(i => i.id == id);
                    if (!target) return;

                    // If clicking unsequenced box and there are sequenced items, auto-reorder first
                    if (target.order === null && this.currentMaxOrder > 0) {
                        this.autoReorderSequenced();
                    }

                    if (target.order === null) {
                        this.currentMaxOrder++;
                        target.order = this.currentMaxOrder;
                    } else {
                        const removedOrder = target.order;
                        target.order = null;
                        this.appItems.forEach(i => {
                            if (i.order !== null && i.order > removedOrder) {
                                i.order--;
                            }
                        });
                        this.currentMaxOrder--;
                    }
                    this.refreshMathJax();
                },

                autoReorderSequenced() {
                    // Get all items with sequence numbers
                    const sequencedItems = this.appItems.filter(i => i.order !== null);
                    
                    if (sequencedItems.length === 0) return;
                    
                    // Sort by sequence number
                    sequencedItems.sort((a, b) => a.order - b.order);
                    
                    // Assign new randomIndex values starting from 0
                    sequencedItems.forEach((item, index) => {
                        item.randomIndex = index;
                    });
                    
                    // Reassign randomIndex for unsequenced items
                    const unsequencedItems = this.appItems.filter(i => i.order === null);
                    const startIndex = sequencedItems.length;
                    unsequencedItems.forEach((item, index) => {
                        item.randomIndex = startIndex + index;
                    });
                    
                    // Nuclear option: Force re-render by destroying and recreating grid
                    this.showGrid = false;
                    this.$nextTick(() => {
                        this.showGrid = true;
                        this.$nextTick(() => {
                            this.initSortable();
                            this.refreshMathJax();
                        });
                    });
                },

                handleSortableDrop(sourceId, targetId) {
                    const source = this.appItems.find(i => i.id == sourceId);
                    const target = this.appItems.find(i => i.id == targetId);

                    if (!source || !target) return;

                    const sNum = source.order;
                    const tNum = target.order;

                    // Always swap randomIndex to maintain physical positions
                    const tempIdx = source.randomIndex;
                    source.randomIndex = target.randomIndex;
                    target.randomIndex = tempIdx;

                    // Handle sequence number logic:
                    // 1. If both have sequential numbers, swap their numbers
                    if (sNum !== null && tNum !== null) {
                        source.order = tNum;
                        target.order = sNum;
                    } 
                    // 2. If source has number and target doesn't, transfer number
                    else if (sNum !== null && tNum === null) {
                        target.order = sNum;
                        source.order = null;
                    }
                    // 3. If target has number and source doesn't, transfer number
                    else if (sNum === null && tNum !== null) {
                        source.order = tNum;
                        target.order = null;
                    }
                    // 4. If neither has a number, positions are already swapped via randomIndex

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
                    return [...this.appItems]
                        .sort((a, b) => a.order - b.order)
                        .map(i => i.id);
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
