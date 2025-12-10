<div class="w-full max-w-4xl bg-white shadow-md rounded-lg p-6">
    <h1 class="text-2xl font-bold mb-6 text-center text-gray-800">{{ __('test.title') }}</h1>

    @if ($currentStep === 1)
        <div class="mb-6">
            <label for="guestName" class="block text-sm font-medium text-gray-700">{{ __('test.your_name') }}</label>
            <input type="text" wire:model="guestName" id="guestName" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2 border" placeholder="{{ __('test.enter_name') }}">
            @error('guestName') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <h2 class="text-xl font-semibold mb-2">{{ __('test.part_1_title') }}</h2>
            <p class="text-gray-600 mb-4">{{ __('test.part_1_instruction') }}</p>
            
            <ul id="part1-list" class="space-y-2" wire:ignore>
                @foreach($part1Items as $item)
                    <li wire:key="item-{{ $item->id }}" data-id="{{ $item->id }}" class="bg-gray-50 p-3 rounded border border-gray-200 cursor-move hover:bg-gray-100 flex items-center">
                        <span class="mr-2 text-gray-400">☰</span>
                        {{ $item->content }}
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="mt-6 flex justify-end">
            <button wire:click="nextStep" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">{{ __('test.next_part') }}</button>
        </div>
    @elseif ($currentStep === 2)
        <div class="mb-4">
            <h2 class="text-xl font-semibold mb-2">{{ __('test.part_2_title') }}</h2>
            <p class="text-gray-600 mb-4">{{ __('test.part_2_instruction') }}</p>

            <ul id="part2-list" class="space-y-2" wire:ignore>
                @foreach($part2Items as $item)
                    <li wire:key="item-{{ $item->id }}" data-id="{{ $item->id }}" class="bg-gray-50 p-3 rounded border border-gray-200 cursor-move hover:bg-gray-100 flex items-center">
                        <span class="mr-2 text-gray-400">☰</span>
                        {{ $item->content }}
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="mt-6 flex justify-end">
            <button wire:click="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">{{ __('test.submit_test') }}</button>
        </div>
    @endif

    <script>
        document.addEventListener('livewire:initialized', () => {
            let part1List = document.getElementById('part1-list');
            if (part1List) {
                new Sortable(part1List, {
                    animation: 150,
                    onEnd: function (evt) {
                        let itemEl = evt.item;
                        let order = Array.from(part1List.children).map(child => child.getAttribute('data-id'));
                        @this.updateRanking(1, order);
                    }
                });
            }

            let part2List = document.getElementById('part2-list');
            if (part2List) {
                new Sortable(part2List, {
                    animation: 150,
                    onEnd: function (evt) {
                        let itemEl = evt.item;
                        let order = Array.from(part2List.children).map(child => child.getAttribute('data-id'));
                        @this.updateRanking(2, order);
                    }
                });
            }
        });

        // Re-initialize on Livewire updates (e.g. step change)
        Livewire.hook('morph.updated', ({ el, component }) => {
             let part1List = document.getElementById('part1-list');
            if (part1List && !part1List.sortable) { // Simple check to avoid double init if possible, though Sortable usually handles it or we create new instance
                 new Sortable(part1List, {
                    animation: 150,
                    onEnd: function (evt) {
                        let order = Array.from(part1List.children).map(child => child.getAttribute('data-id'));
                        @this.updateRanking(1, order);
                    }
                });
            }
            let part2List = document.getElementById('part2-list');
             if (part2List && !part2List.sortable) {
                 new Sortable(part2List, {
                    animation: 150,
                    onEnd: function (evt) {
                        let order = Array.from(part2List.children).map(child => child.getAttribute('data-id'));
                        @this.updateRanking(2, order);
                    }
                });
            }
        });
    </script>
</div>
