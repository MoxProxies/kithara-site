const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
const finePointer = window.matchMedia('(hover: hover) and (pointer: fine)').matches;

/* ---------- Mobile navigation ---------- */
const toggle = document.querySelector('[data-nav-toggle]');
const links = document.getElementById('nav-links');

if (toggle && links) {
    toggle.addEventListener('click', () => {
        const open = links.classList.toggle('open');
        toggle.setAttribute('aria-expanded', String(open));
    });

    links.addEventListener('click', (event) => {
        if (event.target.closest('a')) {
            links.classList.remove('open');
            toggle.setAttribute('aria-expanded', 'false');
        }
    });
}

/* ---------- Header shadow + reading progress ---------- */
const header = document.querySelector('.site-header');
const progress = document.querySelector('[data-progress]');

function onScroll() {
    const y = window.scrollY;
    header?.classList.toggle('scrolled', y > 8);
    if (progress) {
        const max = document.documentElement.scrollHeight - window.innerHeight;
        progress.style.transform = `scaleX(${max > 0 ? Math.min(y / max, 1) : 0})`;
    }
}
window.addEventListener('scroll', onScroll, { passive: true });
onScroll();

/* ---------- Scroll reveal ---------- */
const revealTargets = document.querySelectorAll('[data-reveal], [data-reveal-group]');

if (reduceMotion || !('IntersectionObserver' in window)) {
    revealTargets.forEach((el) => el.classList.add('in'));
} else {
    // Stagger children of a group by giving each an index the CSS turns into a delay
    document.querySelectorAll('[data-reveal-group]').forEach((group) => {
        [...group.children].forEach((child, i) => child.style.setProperty('--i', i));
    });

    const io = new IntersectionObserver((entries) => {
        for (const entry of entries) {
            if (entry.isIntersecting) {
                entry.target.classList.add('in');
                io.unobserve(entry.target);
            }
        }
    }, { rootMargin: '0px 0px -8% 0px', threshold: 0.15 });

    revealTargets.forEach((el) => io.observe(el));
}

/* ---------- Typewriter ---------- */
const sleep = (ms) => new Promise((resolve) => setTimeout(resolve, ms));

async function typeInto(el, text, perChar) {
    for (let i = 1; i <= text.length; i++) {
        el.textContent = text.slice(0, i);
        // Linger a touch on punctuation so it reads like speech
        await sleep(/[.,;:!?]/.test(text[i - 1]) ? perChar * 4 : perChar);
    }
}

async function eraseFrom(el, perChar) {
    while (el.textContent.length) {
        el.textContent = el.textContent.slice(0, -1);
        await sleep(perChar);
    }
}

// Headline: cycle through phrases, typing and erasing in place
document.querySelectorAll('[data-type-cycle]').forEach(async (el) => {
    let phrases;
    try { phrases = JSON.parse(el.dataset.typeCycle); } catch { return; }
    if (reduceMotion || !Array.isArray(phrases) || phrases.length < 2) return;

    el.classList.add('typing');

    // Phrases wrap to different line counts, so pin the heading to its tallest
    // variant and nothing below it moves while the text cycles.
    const heading = el.closest('h1, h2, h3, p') || el.parentElement;
    const original = el.textContent;
    const reserve = () => {
        heading.style.minHeight = '';
        let tallest = 0;
        for (const phrase of phrases) {
            el.textContent = phrase;
            tallest = Math.max(tallest, heading.offsetHeight);
        }
        el.textContent = original;
        heading.style.minHeight = `${tallest}px`;
    };
    reserve();
    window.addEventListener('resize', reserve);

    let index = phrases.indexOf(original.trim());
    if (index < 0) index = 0;

    await sleep(3200);
    for (;;) {
        await eraseFrom(el, 45);
        index = (index + 1) % phrases.length;
        await typeInto(el, phrases[index], 95);
        await sleep(3800);
    }
});

// Transcript demo: type each line in turn as if it were being transcribed, then loop
document.querySelectorAll('[data-transcribe]').forEach(async (panel) => {
    const lines = [...panel.querySelectorAll('[data-line]')];
    if (!lines.length) return;

    const texts = lines.map((line) => line.querySelector('[data-line-text]').textContent);
    if (reduceMotion) return; // leave the static text in place

    // Only run while it is on screen; a hidden loop is wasted work
    let visible = false;
    const io = new IntersectionObserver(([entry]) => { visible = entry.isIntersecting; }, { threshold: 0.3 });
    io.observe(panel);

    for (;;) {
        if (!visible) { await sleep(400); continue; }

        lines.forEach((line) => {
            line.classList.remove('active', 'done');
            line.querySelector('[data-line-text]').textContent = '';
        });
        await sleep(600);

        for (let i = 0; i < lines.length; i++) {
            const line = lines[i];
            line.classList.add('active');
            await typeInto(line.querySelector('[data-line-text]'), texts[i], 40);
            line.classList.replace('active', 'done');
            await sleep(700);
        }
        await sleep(4000);
    }
});

/* ---------- Hero phone tilt ---------- */
const hero = document.querySelector('.hero');
const phone = document.querySelector('.phone');

if (hero && phone && finePointer && !reduceMotion) {
    let frame = 0;
    hero.addEventListener('mousemove', (event) => {
        const rect = hero.getBoundingClientRect();
        const x = (event.clientX - rect.left) / rect.width - 0.5;
        const y = (event.clientY - rect.top) / rect.height - 0.5;
        cancelAnimationFrame(frame);
        frame = requestAnimationFrame(() => {
            phone.style.setProperty('--tilt-x', `${(-y * 6).toFixed(2)}deg`);
            phone.style.setProperty('--tilt-y', `${(x * 8).toFixed(2)}deg`);
        });
    });
    hero.addEventListener('mouseleave', () => {
        phone.style.setProperty('--tilt-x', '0deg');
        phone.style.setProperty('--tilt-y', '0deg');
    });
}

/* ---------- Feature card spotlight ---------- */
if (finePointer && !reduceMotion) {
    document.querySelectorAll('.feature, .plan').forEach((card) => {
        card.addEventListener('mousemove', (event) => {
            const rect = card.getBoundingClientRect();
            card.style.setProperty('--mx', `${event.clientX - rect.left}px`);
            card.style.setProperty('--my', `${event.clientY - rect.top}px`);
        });
    });
}
