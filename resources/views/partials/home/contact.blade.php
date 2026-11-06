@php
    $availability = $site['availability_status'] ?? 'available';
    $availabilityMeta = match ($availability) {
        'limited' => ['label' => 'limited capacity', 'class' => 'border-signal/30 bg-signal/10 text-signal'],
        'unavailable' => ['label' => 'not taking work', 'class' => 'border-ember/30 bg-ember/10 text-ember'],
        default => ['label' => 'open for projects', 'class' => 'border-matrix/30 bg-matrix/10 text-matrix'],
    };
    $contactErrors = $errors->getBag('default')->getMessages();
@endphp

<section id="contact" class="relative scroll-mt-24 py-24">
    <div class="pointer-events-none absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-matrix/20 to-transparent"></div>

    <div class="mx-auto max-w-7xl px-5 sm:px-8">
        <div class="grid gap-10 lg:grid-cols-[0.85fr_1.15fr] lg:gap-14">
            <div class="reveal">
                <x-section-heading
                    eyebrow="contact terminal / 08"
                    title="Send the brief. I will send a point of view."
                    description="Tell me what is changing, what is stuck and what a good outcome looks like. I read every message and reply within 24 hours."
                />

                <div class="mt-8 space-y-3">
                    <a href="mailto:{{ $site['email'] ?? 'hello@portfolio3d.test' }}" class="group flex items-center justify-between gap-4 rounded-xl border border-white/10 bg-white/[0.02] p-4 transition-colors hover:border-matrix/30 hover:bg-matrix/[0.03]">
                        <div class="flex items-center gap-3">
                            <span class="grid h-9 w-9 place-items-center rounded-lg border border-cyber/25 bg-cyber/10 font-mono text-xs text-cyber">@</span>
                            <div>
                                <p class="font-mono text-[9px] uppercase tracking-[0.16em] text-slate-500">email</p>
                                <p class="mt-0.5 font-mono text-xs text-slate-200">{{ $site['email'] ?? 'hello@portfolio3d.test' }}</p>
                            </div>
                        </div>
                        <span class="font-mono text-[10px] text-slate-600 transition-colors group-hover:text-matrix">↗</span>
                    </a>

                    @if (! empty($site['phone']))
                        <div class="flex items-center gap-3 rounded-xl border border-white/10 bg-white/[0.02] p-4">
                            <span class="grid h-9 w-9 place-items-center rounded-lg border border-matrix/25 bg-matrix/10 font-mono text-xs text-matrix">☎</span>
                            <div>
                                <p class="font-mono text-[9px] uppercase tracking-[0.16em] text-slate-500">phone</p>
                                <p class="mt-0.5 font-mono text-xs text-slate-200">{{ $site['phone'] }}</p>
                            </div>
                        </div>
                    @endif

                    <div class="flex items-center gap-3 rounded-xl border border-white/10 bg-white/[0.02] p-4">
                        <span class="grid h-9 w-9 place-items-center rounded-lg border border-plasma/25 bg-plasma/10 font-mono text-xs text-plasma">⌖</span>
                        <div>
                            <p class="font-mono text-[9px] uppercase tracking-[0.16em] text-slate-500">base</p>
                            <p class="mt-0.5 font-mono text-xs text-slate-200">{{ $site['location'] ?? 'Remote worldwide' }}</p>
                        </div>
                    </div>
                </div>

                <div class="mt-6 rounded-xl border {{ $availabilityMeta['class'] }} p-4">
                    <div class="flex items-center justify-between gap-3">
                        <div class="flex items-center gap-2">
                            <span class="relative flex h-1.5 w-1.5">
                                <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-current opacity-60"></span>
                                <span class="relative inline-flex h-1.5 w-1.5 rounded-full bg-current"></span>
                            </span>
                            <p class="font-mono text-[10px] uppercase tracking-[0.16em]">{{ $availabilityMeta['label'] }}</p>
                        </div>
                        <span class="font-mono text-[9px] text-slate-500">response &lt; 24h</span>
                    </div>
                    <p class="mt-2 font-mono text-[10px] leading-5 text-slate-400">{{ $site['availability_text'] ?? 'Available for select projects' }}</p>
                </div>

                <div class="mt-6 flex flex-wrap gap-2">
                    @foreach (array_filter([
                        'github_url' => 'GitHub',
                        'linkedin_url' => 'LinkedIn',
                        'twitter_url' => 'X / Twitter',
                        'dribbble_url' => 'Dribbble',
                    ]) as $key => $label)
                        @if (! empty($site[$key]))
                            <a href="{{ $site[$key] }}" target="_blank" rel="noopener noreferrer" class="chip transition-colors hover:border-matrix/40 hover:text-matrix">{{ $label }} ↗</a>
                        @endif
                    @endforeach
                </div>
            </div>

            <div class="reveal">
                <div class="terminal-shell overflow-hidden rounded-2xl">
                    <div class="flex items-center justify-between border-b border-white/10 bg-white/[0.02] px-4 py-3">
                        <div class="flex items-center gap-3">
                            <div class="terminal-dots flex gap-1.5">
                                <span class="h-2 w-2 rounded-full"></span>
                                <span class="h-2 w-2 rounded-full"></span>
                                <span class="h-2 w-2 rounded-full"></span>
                            </div>
                            <span class="font-mono text-[9px] uppercase tracking-[0.2em] text-slate-500">new-inquiry.sh</span>
                        </div>
                        <span class="font-mono text-[9px] text-slate-600">encrypted · no spam</span>
                    </div>

                    <div x-data="contactForm({ old: @js(old()), errors: @js($contactErrors) })" class="p-5 sm:p-6">
                        @if (session('contact_sent'))
                            <div class="mb-5 rounded-xl border border-matrix/30 bg-matrix/[0.06] p-4">
                                <p class="font-mono text-[10px] uppercase tracking-[0.16em] text-matrix">✓ transmission received</p>
                                <p class="mt-1.5 text-[13px] leading-6 text-slate-300">{{ session('contact_sent') }}</p>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="mb-5 rounded-xl border border-ember/30 bg-ember/[0.06] p-4">
                                <p class="font-mono text-[10px] uppercase tracking-[0.16em] text-ember">! transmission rejected</p>
                                <ul class="mt-2 space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li class="font-mono text-[10px] leading-5 text-slate-400">— {{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('contact.store') }}" class="space-y-4" novalidate @submit="submit($event)">
                            @csrf
                            <div class="hidden" aria-hidden="true">
                                <label for="website">Website</label>
                                <input type="text" name="website" id="website" tabindex="-1" autocomplete="off">
                            </div>

                            <div class="grid gap-4 sm:grid-cols-2">
                                <div>
                                    <label for="contact-name" class="form-label">name <span class="text-ember">*</span></label>
                                    <input
                                        type="text"
                                        name="name"
                                        id="contact-name"
                                        x-model="fields.name"
                                        @blur="validateField('name')"
                                        :aria-invalid="errors.name ? 'true' : 'false'"
                                        class="form-field"
                                        :class="errors.name && touched.name ? '!border-ember/50' : ''"
                                        value="{{ old('name') }}"
                                        placeholder="Your name"
                                        autocomplete="name"
                                        required
                                    >
                                    <p x-show="touched.name && errors.name" x-text="errors.name" class="form-error" x-cloak></p>
                                </div>

                                <div>
                                    <label for="contact-email" class="form-label">email <span class="text-ember">*</span></label>
                                    <input
                                        type="email"
                                        name="email"
                                        id="contact-email"
                                        x-model="fields.email"
                                        @blur="validateField('email')"
                                        :aria-invalid="errors.email ? 'true' : 'false'"
                                        class="form-field"
                                        :class="errors.email && touched.email ? '!border-ember/50' : ''"
                                        value="{{ old('email') }}"
                                        placeholder="you@company.com"
                                        autocomplete="email"
                                        required
                                    >
                                    <p x-show="touched.email && errors.email" x-text="errors.email" class="form-error" x-cloak></p>
                                </div>
                            </div>

                            <div class="grid gap-4 sm:grid-cols-2">
                                <div>
                                    <label for="contact-subject" class="form-label">subject <span class="text-ember">*</span></label>
                                    <input
                                        type="text"
                                        name="subject"
                                        id="contact-subject"
                                        x-model="fields.subject"
                                        @blur="validateField('subject')"
                                        :aria-invalid="errors.subject ? 'true' : 'false'"
                                        class="form-field"
                                        :class="errors.subject && touched.subject ? '!border-ember/50' : ''"
                                        value="{{ old('subject') }}"
                                        placeholder="What are we solving?"
                                        required
                                    >
                                    <p x-show="touched.subject && errors.subject" x-text="errors.subject" class="form-error" x-cloak></p>
                                </div>

                                <div>
                                    <label for="contact-budget" class="form-label">budget range</label>
                                    <select name="budget" id="contact-budget" x-model="fields.budget" class="form-field">
                                        <option value="">Select a range (optional)</option>
                                        @foreach (['Under $5k', '$5k – $15k', '$15k – $50k', '$50k+', 'Not sure yet'] as $budget)
                                            <option value="{{ $budget }}" @selected(old('budget') === $budget)>{{ $budget }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div>
                                <div class="flex items-center justify-between">
                                    <label for="contact-message" class="form-label">brief <span class="text-ember">*</span></label>
                                    <span class="font-mono text-[9px] text-slate-600" x-text="fields.message.length + ' / 5000'">{{ strlen(old('message', '')) }} / 5000</span>
                                </div>
                                <textarea
                                    name="message"
                                    id="contact-message"
                                    rows="6"
                                    x-model="fields.message"
                                    @blur="validateField('message')"
                                    :aria-invalid="errors.message ? 'true' : 'false'"
                                    class="form-field resize-y"
                                    :class="errors.message && touched.message ? '!border-ember/50' : ''"
                                    placeholder="Context, constraints, what a good outcome looks like…"
                                    required
                                >{{ old('message') }}</textarea>
                                <p x-show="touched.message && errors.message" x-text="errors.message" class="form-error" x-cloak></p>
                            </div>

                            <div class="flex flex-wrap items-center justify-between gap-3 border-t border-white/10 pt-4">
                                <p class="font-mono text-[9px] uppercase tracking-[0.14em] text-slate-600">
                                    <span class="text-matrix">›</span> no newsletters. no CRM sequences.
                                </p>
                                <button type="submit" class="btn-primary">
                                    transmit brief <span aria-hidden="true">→</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
