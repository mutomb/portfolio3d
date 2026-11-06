import Alpine from 'alpinejs';

window.Alpine = Alpine;

const COMMANDS = [
    { id: 'help', label: 'help', description: 'Show every available command', icon: '?', section: null },
    { id: 'about', label: 'about', description: 'Jump to the operator profile', icon: '⌁', section: '#about' },
    { id: 'skills', label: 'skills', description: 'Open the tech & data stack matrix', icon: '▦', section: '#stack' },
    { id: 'projects', label: 'projects', description: 'Browse software and data case studies', icon: '◇', section: '#work' },
    { id: 'analytics', label: 'analytics', description: 'See live portfolio signals', icon: '∿', section: '#analytics' },
    { id: 'services', label: 'services', description: 'Explore engagement options', icon: '⌘', section: '#services' },
    { id: 'experience', label: 'experience', description: 'View qualifications and timeline', icon: '≡', section: '#experience' },
    { id: 'reviews', label: 'reviews', description: 'Read client outcomes', icon: '★', section: '#reviews' },
    { id: 'contact', label: 'contact', description: 'Open the contact terminal', icon: '↗', section: '#contact' },
    { id: 'resume', label: 'resume', description: 'Download the latest CV', icon: '↓', section: null },
    { id: 'admin', label: 'admin', description: 'Enter the control center', icon: '▣', section: null },
    { id: 'whoami', label: 'whoami', description: 'Print a short operator summary', icon: '>', section: null },
    { id: 'clear', label: 'clear', description: 'Clear terminal output', icon: '×', section: null },
];

document.addEventListener('alpine:init', () => {
    Alpine.data('commandPalette', () => ({
        open: false,
        query: '',
        activeIndex: 0,
        output: [],
        commands: COMMANDS,

        init() {
            window.addEventListener('keydown', (event) => {
                if ((event.ctrlKey || event.metaKey) && event.key.toLowerCase() === 'k') {
                    event.preventDefault();
                    this.toggle();
                }

                if (event.key === 'Escape' && this.open) {
                    this.close();
                }
            });

            window.addEventListener('open-command-palette', () => this.show());
        },

        get filtered() {
            const query = this.query.trim().toLowerCase();

            if (!query) {
                return this.commands;
            }

            return this.commands.filter((command) => {
                return command.label.includes(query) || command.description.toLowerCase().includes(query);
            });
        },

        show() {
            this.open = true;
            this.query = '';
            this.activeIndex = 0;
            document.body.style.overflow = 'hidden';
            this.$nextTick(() => this.$refs.input?.focus());
        },

        close() {
            this.open = false;
            document.body.style.overflow = '';
        },

        toggle() {
            this.open ? this.close() : this.show();
        },

        move(direction) {
            const count = this.filtered.length;

            if (count === 0) {
                return;
            }

            this.activeIndex = (this.activeIndex + direction + count) % count;
        },

        choose(command = null) {
            const selected = command ?? this.filtered[this.activeIndex];

            if (!selected) {
                return;
            }

            this.run(selected);
        },

        run(command) {
            if (command.id === 'clear') {
                this.output = [];
                this.query = '';
                this.activeIndex = 0;
                this.$nextTick(() => this.$refs.input?.focus());
                return;
            }

            if (command.id === 'help') {
                this.output = [
                    'available commands',
                    ...this.commands.map((item) => `  ${item.label.padEnd(12)} ${item.description}`),
                ];
                this.query = '';
                this.activeIndex = 0;
                return;
            }

            if (command.id === 'whoami') {
                this.output = [
                    'Jeanluc Mutomb — Software Developer & Data Analyst',
                    '7 years shipping Laravel platforms and analytics products.',
                    'Lagos · Nairobi · remote worldwide. Available Q1 2027.',
                ];
                this.query = '';
                this.activeIndex = 0;
                return;
            }

            this.close();

            if (command.id === 'resume') {
                window.location.href = '/resume';
                return;
            }

            if (command.id === 'admin') {
                window.location.href = '/admin';
                return;
            }

            if (command.section) {
                document.querySelector(command.section)?.scrollIntoView({ behavior: 'smooth', block: 'start' });

                if (command.id === 'contact') {
                    window.setTimeout(() => document.querySelector('#contact-name')?.focus(), 700);
                }
            }
        },
    }));

    Alpine.data('typewriter', () => ({
        roles: ['Software Developer', 'Data Analyst', 'Analytics Engineer', 'Systems Builder'],
        text: '',
        roleIndex: 0,
        charIndex: 0,
        deleting: false,
        timer: null,

        init() {
            if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
                this.text = this.roles[0];
                return;
            }

            this.tick();
        },

        destroy() {
            window.clearTimeout(this.timer);
        },

        tick() {
            const role = this.roles[this.roleIndex];

            if (!this.deleting) {
                this.charIndex++;
                this.text = role.slice(0, this.charIndex);

                if (this.charIndex === role.length) {
                    this.deleting = true;
                    this.timer = window.setTimeout(() => this.tick(), 1900);
                    return;
                }

                this.timer = window.setTimeout(() => this.tick(), 62 + Math.random() * 46);
                return;
            }

            this.charIndex--;
            this.text = role.slice(0, this.charIndex);

            if (this.charIndex === 0) {
                this.deleting = false;
                this.roleIndex = (this.roleIndex + 1) % this.roles.length;
                this.timer = window.setTimeout(() => this.tick(), 380);
                return;
            }

            this.timer = window.setTimeout(() => this.tick(), 32);
        },
    }));

    Alpine.data('contactForm', (payload = {}) => ({
        fields: {
            name: payload.old?.name ?? '',
            email: payload.old?.email ?? '',
            subject: payload.old?.subject ?? '',
            budget: payload.old?.budget ?? '',
            message: payload.old?.message ?? '',
        },
        touched: {},
        errors: Object.fromEntries(
            Object.entries(payload.errors ?? {}).map(([key, messages]) => [key, Array.isArray(messages) ? messages[0] : messages]),
        ),

        init() {
            Object.keys(this.errors).forEach((key) => {
                if (key in this.fields) {
                    this.touched[key] = true;
                }
            });
        },

        validateField(field) {
            const value = (this.fields[field] ?? '').trim();
            let message = '';

            if (field === 'name' && value.length < 2) {
                message = 'Enter your name (2+ characters).';
            }

            if (field === 'email' && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) {
                message = 'Enter a valid email address.';
            }

            if (field === 'subject' && value.length < 3) {
                message = 'Add a short subject (3+ characters).';
            }

            if (field === 'message' && value.length < 20) {
                message = `Add more context — ${20 - value.length} more characters needed.`;
            }

            this.touched[field] = true;
            this.errors[field] = message;

            return message === '';
        },

        status(field) {
            if (!this.touched[field]) {
                return null;
            }

            return this.errors[field] ? 'invalid' : 'valid';
        },

        submit(event) {
            const fields = ['name', 'email', 'subject', 'message'];
            const valid = fields.map((field) => this.validateField(field)).every(Boolean);

            if (!valid) {
                event.preventDefault();
                document.querySelector('[aria-invalid="true"]')?.focus();
            }
        },
    }));

    Alpine.data('adminMetrics', (initial = {}) => ({
        metrics: initial,
        pulse: false,
        timer: null,

        init() {
            this.timer = window.setInterval(() => this.refresh(), 20000);
        },

        destroy() {
            window.clearInterval(this.timer);
        },

        async refresh() {
            try {
                const response = await fetch('/admin/metrics', {
                    headers: { Accept: 'application/json' },
                    credentials: 'same-origin',
                });

                if (!response.ok) {
                    return;
                }

                this.metrics = await response.json();
                this.pulse = true;
                window.setTimeout(() => (this.pulse = false), 900);
            } catch (error) {
                // Live metrics are best-effort.
            }
        },
    }));
});

Alpine.start();

const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

document.addEventListener('click', (event) => {
    const link = event.target.closest('[data-track-project]');

    if (!link || !csrfToken) {
        return;
    }

    const url = link.dataset.trackUrl;
    const eventType = link.dataset.trackType;

    if (!url || !eventType) {
        return;
    }

    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            Accept: 'application/json',
        },
        body: JSON.stringify({ event_type: eventType }),
        credentials: 'same-origin',
        keepalive: true,
    }).catch(() => {});
});

document.addEventListener('click', async (event) => {
    const button = event.target.closest('[data-copy]');

    if (!button) {
        return;
    }

    const value = button.dataset.copy;
    const original = button.dataset.label ?? button.textContent;

    try {
        await navigator.clipboard.writeText(value);
        button.textContent = 'copied';
        window.setTimeout(() => (button.textContent = original), 1400);
    } catch (error) {
        // Clipboard permissions are optional.
    }
});

const initReveal = () => {
    const elements = document.querySelectorAll('.reveal');

    if (!('IntersectionObserver' in window)) {
        elements.forEach((element) => element.classList.add('is-visible'));
        return;
    }

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.08, rootMargin: '0px 0px -40px 0px' });

    elements.forEach((element) => observer.observe(element));
};

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initReveal);
} else {
    initReveal();
}
