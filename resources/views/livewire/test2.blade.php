<div>
    <!-- MathJax Config -->
    <script>
        window.MathJax = {
            tex: {
                inlineMath: [['$', '$'], ['\\(', '\\)']]
            },
            svg: {
                fontCache: 'global'
            }
        };
    </script>
    <script type="text/javascript" id="MathJax-script" async
        src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-svg.js">
    </script>
    
    <script src="https://cdn.jsdelivr.net/npm/mobile-drag-drop@2.3.0-rc.2/index.min.js"></script>
    <script>
        // Polyfill for mobile drag and drop
        var polyfillOptions = {
            dragImageTranslateOverride: MobileDragDrop.scrollBehaviourDragImageTranslateOverride
        };
        MobileDragDrop.polyfill(polyfillOptions);

        // Fix for iOS/Android scrolling issues while dragging
        window.addEventListener('touchmove', function() {}, {passive: false});
    </script>

    <style>
        .formula-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
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

    <!-- Content -->
    <div class="bg-gray-50 text-gray-800 min-h-screen flex flex-col">
    
    @if ($currentStep === 1)
        <!-- Step 1: Name Input -->
        <div class="h-[35vh] flex flex-col items-center justify-end p-8 text-center">
             <h1 class="text-3xl font-bold text-gray-900 mb-2">Alternativa Test 2</h1>
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
        <div wire:key="step-2" x-data="dragDropLogic(@js($part1Items), 1)" x-init="init()" class="w-full h-full flex flex-col">
            
            <!-- Header/Instructions -->
            <div class="h-[35vh] flex flex-col items-center justify-end p-8 text-center">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ __('test.part_1_title') }}</h1>
                <p class="text-gray-600 max-w-lg mb-4">{{ __('test.part_1_instruction') }} (Fórmulas)</p>
                
                <div class="flex flex-wrap justify-center gap-2 mb-4">
                    <div class="text-xs text-blue-600 font-medium bg-blue-50 px-3 py-1 rounded-full border border-blue-100">
                        Clic: Numerar secuencial
                    </div>
                    <div class="text-xs text-indigo-600 font-medium bg-indigo-50 px-3 py-1 rounded-full border border-indigo-100">
                        Arrastrar: Intercambiar
                    </div>
                    <button @click="resetOrder()" class="text-xs text-gray-600 font-medium bg-white px-3 py-1 rounded-full border border-gray-200 hover:bg-gray-50 transition-colors">
                        Reiniciar Random
                    </button>
                </div>

                <div x-show="isComplete" class="animate-bounce mt-2">
                    <button @click="submitStep()" class="bg-indigo-600 text-white px-6 py-2 rounded-lg font-bold shadow-lg hover:bg-indigo-700 transition">
                        {{ __('test.next_part') }}
                    </button>
                </div>
            </div>

            <!-- Grid -->
            <div class="w-full max-w-6xl mx-auto px-4 pb-24">
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    <template x-for="item in sortedAppItems" :key="item.id">
                        <div :id="'card-' + item.id"
                             :draggable="true"
                             @click="handleClick(item.id)"
                             @dragstart="handleDragStart($event, item.id)"
                             @dragend="handleDragEnd($event)"
                             @dragover.prevent="handleDragOver($event)"
                             @dragleave="handleDragLeave($event)"
                             @drop.prevent="handleDrop($event, item.id)"
                             :class="`formula-card relative border-2 rounded-lg bg-white flex items-center justify-center cursor-move select-none hover:shadow-md ${item.order !== null ? 'selected' : 'border-gray-200'}`">
                            
                            <div class="text-xl md:text-2xl font-serif pointer-events-none p-4 text-center">
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
        <div wire:key="step-3" x-data="dragDropLogic(@js($part2Items), 2)" x-init="init()" class="w-full h-full flex flex-col">
             
            <!-- Header -->
            <div class="h-[35vh] flex flex-col items-center justify-end p-8 text-center">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ __('test.part_2_title') }}</h1>
                <p class="text-gray-600 max-w-lg mb-4">{{ __('test.part_2_instruction') }} (Fórmulas)</p>

                <div class="flex flex-wrap justify-center gap-2 mb-4">
                    <div class="text-xs text-blue-600 font-medium bg-blue-50 px-3 py-1 rounded-full border border-blue-100">
                        Clic: Numerar secuencial
                    </div>
                    <div class="text-xs text-indigo-600 font-medium bg-indigo-50 px-3 py-1 rounded-full border border-indigo-100">
                        Arrastrar: Intercambiar
                    </div>
                    <button @click="resetOrder()" class="text-xs text-gray-600 font-medium bg-white px-3 py-1 rounded-full border border-gray-200 hover:bg-gray-50 transition-colors">
                        Reiniciar Random
                    </button>
                </div>

                <div x-show="isComplete" class="animate-bounce mt-2">
                    <button @click="submitFinal()" class="bg-green-600 text-white px-6 py-2 rounded-lg font-bold shadow-lg hover:bg-green-700 transition">
                        {{ __('test.submit_test') }}
                    </button>
                </div>
            </div>

            <!-- Grid -->
            <div class="w-full max-w-6xl mx-auto px-4 pb-24">
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    <template x-for="item in sortedAppItems" :key="item.id">
                        <div :id="'card-' + item.id"
                             :draggable="true"
                             @click="handleClick(item.id)"
                             @dragstart="handleDragStart($event, item.id)"
                             @dragend="handleDragEnd($event)"
                             @dragover.prevent="handleDragOver($event)"
                             @dragleave="handleDragLeave($event)"
                             @drop.prevent="handleDrop($event, item.id)"
                             :class="`formula-card relative border-2 rounded-lg bg-white flex items-center justify-center cursor-move select-none hover:shadow-md ${item.order !== null ? 'selected' : 'border-gray-200'}`">
                            
                            <div class="text-xl md:text-2xl font-serif pointer-events-none p-4 text-center">
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
            Alpine.data('dragDropLogic', (items, partNum) => ({
                items: [], // Original items from DB
                appItems: [], // Local state
                currentMaxOrder: 0,
                draggedId: null,
                partNumber: partNum,
                justDragged: false, // Flag to prevent click after drag

                init() {
                    // Initialize
                    this.items = items;
                    this.resetOrder();
                },

                resetOrder() {
                    this.currentMaxOrder = 0;
                    // Provide random index
                    const indices = this.shuffle(Array.from({length: this.items.length}, (_, i) => i));
                    
                    this.appItems = this.items.map((item, index) => ({
                        id: item.id,
                        display_content: item.display_content,
                        order: null, // User selected order (1-18)
                        randomIndex: indices[index] // Initial random shuffle position
                    }));
                    
                    this.refreshMathJax();
                },

                get sortedAppItems() {
                    return [...this.appItems].sort((a, b) => {
                        // Sorted by Order if present, otherwise by randomIndex
                        if (a.order !== null && b.order !== null) return a.order - b.order;
                        if (a.order !== null) return -1; // Ordered items first
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
                    // Prevent click if currently dragging or just finished dragging
                    if (this.draggedId || this.justDragged) return;
                    
                    const target = this.appItems.find(i => i.id === id);
                    if (!target) return;

                    if (target.order === null) {
                        this.currentMaxOrder++;
                        target.order = this.currentMaxOrder;
                    } else {
                        // Deselect and shift others down
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

                handleDragStart(e, id) {
                    this.draggedId = id;
                    e.target.classList.add('dragging');
                    e.dataTransfer.effectAllowed = 'move';
                    // We need to store ID
                    e.dataTransfer.setData('text/plain', id);
                },

                handleDragEnd(e) {
                    e.target.classList.remove('dragging');
                    document.querySelectorAll('.drag-over').forEach(el => el.classList.remove('drag-over'));
                    this.draggedId = null;
                    
                    // Set flag to ignore subsequent clicks (ghost clicks on mobile)
                    this.justDragged = true;
                    setTimeout(() => {
                        this.justDragged = false;
                    }, 500); // 500ms debounce
                },

                handleDragOver(e) {
                    e.currentTarget.classList.add('drag-over');
                },

                handleDragLeave(e) {
                    e.currentTarget.classList.remove('drag-over');
                },

                handleDrop(e, targetId) {
                    const sourceId = this.draggedId; 
                    if (!sourceId || sourceId === targetId) return;

                    const source = this.appItems.find(i => i.id === sourceId);
                    const target = this.appItems.find(i => i.id === targetId);

                    if (!source || !target) return;

                    const sNum = source.order;
                    const tNum = target.order;

                    if (sNum !== null && tNum === null) {
                        // Source (Ordered) dropped on Target (Unordered)
                        // Move Source to Target's random position? 
                        // Or just swap Order? 
                        // Logic in prompt: 
                        // target.order = sNum; source.order = null; swap randomIndices
                        target.order = sNum;
                        source.order = null;
                        
                        const tempIdx = source.randomIndex;
                        source.randomIndex = target.randomIndex;
                        target.randomIndex = tempIdx;

                    } else if (sNum !== null && tNum !== null) {
                        // Both Ordered: Swap Orders
                        source.order = tNum;
                        target.order = sNum;

                    } else if (sNum === null && tNum === null) {
                        // Both Unordered: Swap Random Indices (positions)
                        const tempIdx = source.randomIndex;
                        source.randomIndex = target.randomIndex;
                        target.randomIndex = tempIdx;

                    } else if (sNum === null && tNum !== null) {
                        // Source (Unordered) dropped on Target (Ordered)
                        // Take Target's order?
                        // Logic in prompt: source order = tNum, target order = null, swap random
                        source.order = tNum;
                        target.order = null;
                        
                        const tempIdx = source.randomIndex;
                        source.randomIndex = target.randomIndex;
                        target.randomIndex = tempIdx;
                    }

                    this.refreshMathJax();
                },
                
                refreshMathJax() {
                    // Wait for Alpine to update DOM then typeset
                    this.$nextTick(() => {
                        if (window.MathJax && window.MathJax.typesetPromise) {
                           MathJax.typesetPromise();
                        }
                    });
                },

                getFinalRanking() {
                    // Return array of IDs sorted by their Order (1-18)
                    return [...this.appItems]
                        .sort((a, b) => a.order - b.order)
                        .map(i => i.id);
                },

                submitStep() {
                    const ranking = this.getFinalRanking();
                    // Send to Livewire
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
