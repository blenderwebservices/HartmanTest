<?php

use App\Ai\Agents\ChatAgent;
use Livewire\Volt\Component;
use Laravel\Ai\Messages\Message;
use Illuminate\Support\Str;

new class extends Component {
    public $isOpen = false;
    public $message = '';
    public $messages = [];

    public function mount()
    {
        $this->messages[] = [
            'role'    => 'assistant',
            'content' => '¡Hola! Soy el asistente IA del Hartman Test. Puedo ayudarte a entender tu perfil axiológico y los resultados del test. ¿En qué puedo ayudarte hoy?',
            'time'    => now()->format('H:i'),
        ];
    }

    public function toggleChat()
    {
        $this->isOpen = !$this->isOpen;
        if ($this->isOpen) {
            $this->dispatch('chat-opened');
        }
    }

    public function sendMessage()
    {
        if (empty(trim($this->message))) {
            return;
        }

        $userMessage    = $this->message;
        $this->messages[] = [
            'role'    => 'user',
            'content' => $userMessage,
            'time'    => now()->format('H:i'),
        ];
        $this->message = '';

        // Preparar historial para el agente
        $history = collect($this->messages)->map(function ($msg) {
            return new Message($msg['role'], $msg['content']);
        })->toArray();

        // Llamar al agente
        try {
            $agent    = (new ChatAgent())->withHistory($history);
            $response = $agent->prompt($userMessage);

            $this->messages[] = [
                'role'    => 'assistant',
                'content' => (string) $response,
                'time'    => now()->format('H:i'),
            ];
        } catch (\Exception $e) {
            $this->messages[] = [
                'role'    => 'assistant',
                'content' => 'Lo siento, hubo un error al procesar tu mensaje. Por favor intenta de nuevo más tarde.',
                'time'    => now()->format('H:i'),
            ];
        }

        $this->dispatch('message-sent');
    }
};

?>

<div class="fixed bottom-6 right-6 z-[100] flex flex-col items-end" x-data="{ open: @entangle('isOpen') }">
    <style>
        .prose-chat p { margin-bottom: 0.5rem; }
        .prose-chat p:last-child { margin-bottom: 0; }
        .prose-chat ul, .prose-chat ol { margin-left: 1.25rem; margin-bottom: 0.5rem; list-style-type: disc; }
        .prose-chat li { margin-bottom: 0.25rem; }
        .prose-chat strong { font-weight: 700; color: #0f172a; }
        .prose-chat em { font-style: italic; }
        .katex { font-size: 1.1em; }
    </style>

    <!-- Chat Window -->
    <div x-show="open"
         x-transition:enter="transition ease-out duration-300 transform"
         x-transition:enter-start="opacity-0 translate-y-10 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-200 transform"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-10 scale-95"
         class="mb-4 w-80 md:w-96 h-[500px] bg-white rounded-3xl shadow-2xl flex flex-col overflow-hidden border border-slate-100"
         x-cloak>

        <!-- Header (WhatsApp style) -->
        <div class="bg-[#075e54] p-4 text-white flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="relative">
                    <div class="w-10 h-10 rounded-full bg-indigo-200 flex items-center justify-center text-indigo-700 font-bold text-sm border border-white/20">
                        HT
                    </div>
                    <div class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-[#075e54] rounded-full"></div>
                </div>
                <div>
                    <h4 class="font-bold text-sm">Asistente Hartman Test</h4>
                    <span class="text-[10px] opacity-80" wire:loading.remove wire:target="sendMessage">En línea (Asistente IA)</span>
                    <span class="text-[10px] opacity-80 animate-pulse" wire:loading wire:target="sendMessage" x-cloak>Escribiendo...</span>
                </div>
            </div>
            <button @click="open = false" class="hover:bg-white/10 p-1 rounded-full transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <!-- Chat Area -->
        <div class="flex-grow overflow-y-auto p-4 space-y-4 bg-[#e5ddd5] scroll-smooth" id="chat-messages">
            <div class="text-center">
                <span class="bg-white/60 text-[10px] px-2 py-1 rounded-lg text-slate-500 uppercase tracking-wider font-bold shadow-sm">Hoy</span>
            </div>

            @foreach($messages as $index => $msg)
                <div class="flex {{ $msg['role'] === 'user' ? 'justify-end' : 'justify-start' }}" id="msg-{{ $index }}">
                    <div class="max-w-[85%] rounded-2xl p-3 shadow-sm relative {{ $msg['role'] === 'user' ? 'bg-[#dcf8c6] rounded-tr-none' : 'bg-white rounded-tl-none' }}">
                        <div class="text-sm text-slate-800 leading-relaxed prose-chat">
                            {!! Str::markdown($msg['content']) !!}
                        </div>
                        <div class="flex justify-end gap-1 mt-1">
                            <span class="text-[9px] text-slate-400">{{ $msg['time'] }}</span>
                            @if($msg['role'] === 'user')
                                <svg class="w-3 h-3 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach

            <!-- Typing Indicator -->
            <div wire:loading wire:target="sendMessage" class="flex justify-start">
                <div class="bg-white rounded-2xl rounded-tl-none p-3 shadow-sm flex gap-1 items-center">
                    <span class="w-1.5 h-1.5 bg-slate-400 rounded-full animate-bounce [animation-delay:-0.3s]"></span>
                    <span class="w-1.5 h-1.5 bg-slate-400 rounded-full animate-bounce [animation-delay:-0.15s]"></span>
                    <span class="w-1.5 h-1.5 bg-slate-400 rounded-full animate-bounce"></span>
                </div>
            </div>
        </div>

        <!-- Input Area -->
        <div class="p-3 bg-[#f0f2f5] flex items-center gap-2">
            <div class="flex-grow bg-white rounded-2xl flex items-center px-4 border border-slate-200 focus-within:ring-2 focus-within:ring-indigo-500 transition-all">
                <textarea wire:model="message"
                          wire:keydown.enter.prevent="sendMessage"
                          placeholder="Escribe un mensaje..."
                          rows="1"
                          class="w-full bg-transparent border-0 focus:ring-0 py-2 text-sm resize-none"></textarea>
            </div>
            <button wire:click="sendMessage"
                    class="w-10 h-10 bg-[#075e54] text-white rounded-full flex items-center justify-center hover:bg-[#128c7e] transition-all shadow-lg active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed"
                    wire:loading.attr="disabled"
                    wire:target="sendMessage">
                <svg class="w-5 h-5 ml-0.5" wire:loading.remove wire:target="sendMessage" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                <div wire:loading wire:target="sendMessage" class="w-5 h-5 border-2 border-white/30 border-t-white rounded-full animate-spin"></div>
            </button>
        </div>
    </div>

    <!-- Floating Button -->
    <button @click="open = !open"
            class="w-16 h-16 bg-[#25d366] text-white rounded-full shadow-2xl flex items-center justify-center hover:scale-105 transition-all transform active:scale-90 group relative"
            id="chatbot-trigger">
        <span class="absolute -top-1 -right-1 flex h-4 w-4" x-show="!open">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
            <span class="relative inline-flex rounded-full h-4 w-4 bg-red-500"></span>
        </span>
        <!-- Open icon -->
        <svg class="w-8 h-8" x-show="!open" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
        <!-- Close icon -->
        <svg class="w-8 h-8" x-show="open" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
    </button>
</div>

@script
<script>
    $wire.on('message-sent', () => {
        // Small delay to allow KaTeX and Markdown to finish rendering/applying styles
        setTimeout(() => {
            const chatMessages = document.getElementById('chat-messages');
            if (!chatMessages) return;

            // Find the last user message
            const userMessages = chatMessages.querySelectorAll('.flex.justify-end');
            
            if (userMessages.length > 0) {
                const lastUserMsg = userMessages[userMessages.length - 1];
                
                // Use scrollIntoView with start alignment to put message at the top
                lastUserMsg.scrollIntoView({ 
                    behavior: 'smooth', 
                    block: 'start', 
                    inline: 'nearest' 
                });
            } else {
                chatMessages.scrollTo({
                    top: chatMessages.scrollHeight,
                    behavior: 'smooth'
                });
            }
        }, 100);
    });

    $wire.on('chat-opened', () => {
        $nextTick(() => {
            const chatMessages = document.getElementById('chat-messages');
            if (chatMessages) {
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }
        });
    });
</script>
@endscript
