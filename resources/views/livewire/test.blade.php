<div>
    <h1 class="text-2xl font-bold mb-6 text-center text-gray-800">{{ __('test.title') }}</h1>

    @if ($currentStep === 1)
        <!-- Step 1: Name Input -->
        <div class="w-full max-w-md mx-auto bg-white shadow-md rounded-lg p-8 mt-10">
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
        <!-- Step 2: Part 1 -->
        <div class="w-full max-w-4xl mx-auto h-[calc(100vh-100px)] flex flex-col"
             x-data="{
                 initSortable() {
                     let list = document.getElementById('part1-list');
                     let container = document.getElementById('scroll-container-1');
                     if (!list || !container) return;

                     new Sortable(list, {
                         animation: 150,
                         ghostClass: 'bg-indigo-100',
                         forceFallback: true,
                         scroll: true,
                         scrollSensitivity: 150,
                         scrollSpeed: 20,
                         bubbleScroll: true,
                         onEnd: (evt) => {
                             let order = Array.from(list.children).map(child => child.getAttribute('data-id'));
                             $wire.updateRanking(1, order);
                         }
                     });
                 }
             }"
             x-init="initSortable()">
            
            <div class="bg-white shadow-lg rounded-lg flex-1 flex flex-col overflow-hidden relative">
                <div class="p-4 border-b bg-gray-50 z-20">
                    <h2 class="text-xl font-bold text-center text-gray-800">{{ __('test.part_1_title') }}</h2>
                    <p class="text-sm text-center text-gray-600">{{ __('test.part_1_instruction') }}</p>
                </div>

                <div id="scroll-container-1" class="flex-1 relative overflow-hidden">
                    <div class="absolute top-0 left-0 right-0 h-20 bg-gradient-to-b from-white/90 to-transparent z-10 pointer-events-none"></div>
                    <div class="absolute bottom-0 left-0 right-0 h-20 bg-gradient-to-t from-white/90 to-transparent z-10 pointer-events-none"></div>
                    
                    <ul id="part1-list" class="divide-y divide-gray-200 overflow-y-auto h-full p-6 space-y-3" wire:ignore>
                        @foreach($part1Items as $item)
                            <li data-id="{{ $item->id }}" wire:key="item-{{ $item->id }}" class="bg-white border border-gray-200 p-4 rounded-lg shadow-sm cursor-move hover:bg-indigo-50 hover:border-indigo-300 transition-all flex items-center group">
                                <span class="mr-4 text-gray-400 group-hover:text-indigo-500">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"></path></svg>
                                </span>
                                <span class="text-lg font-medium text-gray-700 group-hover:text-gray-900">{{ $item->getTranslation('content', app()->getLocale()) }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
                
                <div class="p-4 border-t bg-gray-50 z-20 text-center">
                    <button wire:click="nextStep" class="bg-indigo-600 text-white px-8 py-3 rounded-lg hover:bg-indigo-700 font-bold shadow-md transition-transform transform hover:scale-105">
                        {{ __('test.next_part') }}
                    </button>
                </div>
            </div>
        </div>

    @elseif ($currentStep === 3)
        <!-- Step 3: Part 2 -->
        <div class="w-full max-w-4xl mx-auto h-[calc(100vh-100px)] flex flex-col"
             x-data="{
                 initSortable() {
                     let list = document.getElementById('part2-list');
                     let container = document.getElementById('scroll-container-2');
                     if (!list || !container) return;

                     new Sortable(list, {
                         animation: 150,
                         ghostClass: 'bg-indigo-100',
                         forceFallback: true,
                         scroll: true,
                         scrollSensitivity: 150,
                         scrollSpeed: 20,
                         bubbleScroll: true,
                         onEnd: (evt) => {
                             let order = Array.from(list.children).map(child => child.getAttribute('data-id'));
                             $wire.updateRanking(2, order);
                         }
                     });
                 }
             }"
             x-init="initSortable()">

            <div class="bg-white shadow-lg rounded-lg flex-1 flex flex-col overflow-hidden relative">
                <div class="p-4 border-b bg-gray-50 z-20">
                    <h2 class="text-xl font-bold text-center text-gray-800">{{ __('test.part_2_title') }}</h2>
                    <p class="text-sm text-center text-gray-600">{{ __('test.part_2_instruction') }}</p>
                </div>

                <div id="scroll-container-2" class="flex-1 relative overflow-hidden">
                    <div class="absolute top-0 left-0 right-0 h-20 bg-gradient-to-b from-white/90 to-transparent z-10 pointer-events-none"></div>
                    <div class="absolute bottom-0 left-0 right-0 h-20 bg-gradient-to-t from-white/90 to-transparent z-10 pointer-events-none"></div>

                    <ul id="part2-list" class="divide-y divide-gray-200 overflow-y-auto h-full p-6 space-y-3" wire:ignore>
                        @foreach($part2Items as $item)
                            <li data-id="{{ $item->id }}" wire:key="item-{{ $item->id }}" class="bg-white border border-gray-200 p-4 rounded-lg shadow-sm cursor-move hover:bg-indigo-50 hover:border-indigo-300 transition-all flex items-center group">
                                <span class="mr-4 text-gray-400 group-hover:text-indigo-500">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"></path></svg>
                                </span>
                                <span class="text-lg font-medium text-gray-700 group-hover:text-gray-900">{{ $item->getTranslation('content', app()->getLocale()) }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="p-4 border-t bg-gray-50 z-20 text-center">
                    <button wire:click="submit" class="bg-green-600 text-white px-8 py-3 rounded-lg hover:bg-green-700 font-bold shadow-md transition-transform transform hover:scale-105">
                        {{ __('test.submit_test') }}
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
