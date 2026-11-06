<div
    x-data="commandPalette"
    x-show="open"
    x-cloak
    x-transition.opacity.duration.180ms
    class="fixed inset-0 z-[100] flex items-start justify-center bg-void/80 px-4 pt-[10vh] backdrop-blur-md sm:pt-[14vh]"
    @click.self="close()"
    role="dialog"
    aria-modal="true"
    aria-label="Command palette"
>
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-3 scale-[0.98]"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-120"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 translate-y-2 scale-[0.99]"
        class="terminal-shell w-full max-w-2xl overflow-hidden rounded-2xl"
    >
        <div class="flex items-center justify-between border-b border-white/10 bg-white/[0.02] px-4 py-3">
            <div class="flex items-center gap-3">
                <div class="terminal-dots flex items-center gap-1.5">
                    <span class="h-2 w-2 rounded-full"></span>
                    <span class="h-2 w-2 rounded-full"></span>
                    <span class="h-2 w-2 rounded-full"></span>
                </div>
                <span class="font-mono text-[10px] uppercase tracking-[0.2em] text-slate-500">visitor@portfolio3d: ~</span>
            </div>
            <button type="button" @click="close()" class="rounded-md border border-white/10 px-2 py-1 font-mono text-[9px] uppercase tracking-[0.14em] text-slate-500 transition-colors hover:border-ember/40 hover:text-ember">
                esc
            </button>
        </div>

        <div x-show="output.length" x-cloak class="max-h-52 overflow-y-auto border-b border-white/10 bg-void/60 px-5 py-4">
            <template x-for="(line, index) in output" :key="index">
                <p class="whitespace-pre-wrap font-mono text-[11px] leading-6 text-slate-400" :class="line.startsWith('available') ? 'text-matrix' : ''" x-text="line"></p>
            </template>
        </div>

        <div class="flex items-center gap-3 border-b border-white/10 px-5 py-4">
            <span class="font-mono text-sm text-matrix">›</span>
            <input
                x-ref="input"
                x-model="query"
                @input="activeIndex = 0"
                @keydown.arrow-down.prevent="move(1)"
                @keydown.arrow-up.prevent="move(-1)"
                @keydown.enter.prevent="choose()"
                type="text"
                autocomplete="off"
                spellcheck="false"
                class="w-full bg-transparent font-mono text-sm text-slate-100 placeholder:text-slate-600 focus:outline-none"
                placeholder="type help, projects, analytics, contact…"
                aria-label="Command input"
            >
            <kbd class="hidden rounded border border-white/10 bg-white/5 px-2 py-1 font-mono text-[9px] uppercase tracking-[0.14em] text-slate-500 sm:block">ctrl k</kbd>
        </div>

        <div class="max-h-[46vh] overflow-y-auto p-2">
            <template x-for="(command, index) in filtered" :key="command.id">
                <button
                    type="button"
                    @click="choose(command)"
                    @mouseenter="activeIndex = index"
                    class="flex w-full items-center gap-3 rounded-xl px-3 py-2.5 text-left transition-colors"
                    :class="activeIndex === index ? 'bg-matrix/10' : 'hover:bg-white/[0.03]'"
                >
                    <span
                        class="grid h-8 w-8 shrink-0 place-items-center rounded-lg border font-mono text-xs"
                        :class="activeIndex === index ? 'border-matrix/40 bg-matrix/10 text-matrix' : 'border-white/10 bg-white/[0.02] text-slate-500'"
                        x-text="command.icon"
                    ></span>
                    <span class="min-w-0 flex-1">
                        <span class="block font-mono text-xs text-slate-200" x-text="command.label"></span>
                        <span class="mt-0.5 block truncate text-[11px] text-slate-500" x-text="command.description"></span>
                    </span>
                    <span x-show="activeIndex === index" class="font-mono text-[10px] text-matrix/70">↵</span>
                </button>
            </template>

            <div x-show="filtered.length === 0" class="px-4 py-8 text-center">
                <p class="font-mono text-xs text-slate-500">No command matched "<span class="text-slate-300" x-text="query"></span>"</p>
                <p class="mt-2 font-mono text-[10px] uppercase tracking-[0.16em] text-slate-600">try help · projects · contact</p>
            </div>
        </div>

        <div class="flex flex-wrap items-center justify-between gap-2 border-t border-white/10 bg-white/[0.02] px-4 py-2.5 font-mono text-[9px] uppercase tracking-[0.14em] text-slate-600">
            <div class="flex items-center gap-4">
                <span><span class="text-slate-400">↑↓</span> navigate</span>
                <span><span class="text-slate-400">↵</span> run</span>
                <span><span class="text-slate-400">esc</span> close</span>
            </div>
            <span class="text-matrix/50">keyboard-first navigation</span>
        </div>
    </div>
</div>
