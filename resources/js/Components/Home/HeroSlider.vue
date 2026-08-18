<script setup>
import { computed, onMounted, onUnmounted, ref, watch } from 'vue';

const props = defineProps({
    slides: {
        type: Array,
        required: true,
    },
});

const current = ref(0);
const paused = ref(false);
const bgColor = ref('#e8f4f8');
const darkText = ref(true);
const palette = ref({});
let timer;

const currentSlide = computed(() => props.slides[current.value] ?? props.slides[0]);

const sampleBackground = (src) =>
    new Promise((resolve) => {
        const image = new Image();
        image.crossOrigin = 'anonymous';
        image.onload = () => {
            const size = 48;
            const canvas = document.createElement('canvas');
            canvas.width = size;
            canvas.height = size;
            const ctx = canvas.getContext('2d', { willReadFrequently: true });
            if (!ctx) {
                resolve('#dbeafe');
                return;
            }
            ctx.drawImage(image, 0, 0, size, size);
            const { data } = ctx.getImageData(0, 0, size, size);
            let r = 0;
            let g = 0;
            let b = 0;
            let n = 0;

            for (let i = 0; i < data.length; i += 4) {
                const pr = data[i];
                const pg = data[i + 1];
                const pb = data[i + 2];
                const pa = data[i + 3];
                if (pa < 90) {
                    continue;
                }
                if (pr > 232 && pg > 232 && pb > 232) {
                    continue;
                }
                r += pr;
                g += pg;
                b += pb;
                n += 1;
            }

            if (!n) {
                resolve('#dbeafe');
                return;
            }

            r = Math.round(r / n);
            g = Math.round(g / n);
            b = Math.round(b / n);

            const luminance = 0.299 * r + 0.587 * g + 0.114 * b;
            if (luminance > 210) {
                r = Math.round(r * 0.82);
                g = Math.round(g * 0.82);
                b = Math.round(b * 0.82);
            }

            resolve(`rgb(${r}, ${g}, ${b})`);
        };
        image.onerror = () => resolve('#dbeafe');
        image.src = src;
    });

const applyBackground = () => {
    const slide = currentSlide.value;
    if (!slide) {
        return;
    }
    const color = palette.value[slide.image];
    if (!color) {
        return;
    }
    bgColor.value = color;
    const match = color.match(/\d+/g);
    if (!match) {
        darkText.value = true;
        return;
    }
    const [r, g, b] = match.map(Number);
    darkText.value = 0.299 * r + 0.587 * g + 0.114 * b > 150;
};

watch(current, applyBackground);

const hasMultiple = computed(() => props.slides.length > 1);

const next = () => {
    if (!hasMultiple.value) {
        return;
    }
    current.value = (current.value + 1) % props.slides.length;
};

const prev = () => {
    if (!hasMultiple.value) {
        return;
    }
    current.value = (current.value - 1 + props.slides.length) % props.slides.length;
};

const goTo = (index) => {
    current.value = index;
};

const onKey = (event) => {
    if (event.key === 'ArrowRight') {
        next();
    }
    if (event.key === 'ArrowLeft') {
        prev();
    }
};

onMounted(async () => {
    window.addEventListener('keydown', onKey);
    const nextPalette = { ...palette.value };
    await Promise.all(
        props.slides.map(async (slide) => {
            nextPalette[slide.image] = await sampleBackground(slide.image);
        }),
    );
    palette.value = nextPalette;
    applyBackground();
    if (hasMultiple.value) {
        timer = setInterval(() => {
            if (!paused.value) {
                next();
            }
        }, 6500);
    }
});

onUnmounted(() => {
    window.removeEventListener('keydown', onKey);
    clearInterval(timer);
});
</script>

<template>
    <section
        class="relative h-[100svh] min-h-screen overflow-hidden transition-[background-color] duration-700 ease-out"
        :style="{ backgroundColor: bgColor }"
        aria-roledescription="carousel"
        aria-label="Productos destacados"
        @mouseenter="paused = true"
        @mouseleave="paused = false"
    >
        <div
            class="pointer-events-none absolute inset-0 scale-125 bg-cover bg-center opacity-45 blur-3xl"
            :style="{ backgroundImage: currentSlide ? `url('${currentSlide.image}')` : 'none' }"
            aria-hidden="true"
        />

        <h1 class="sr-only">
            Globos Sensacionales: fabricación de globos de látex para distribuidores en todo México
        </h1>

        <article
            v-for="(slide, index) in slides"
            :key="slide.sku || slide.alt || index"
            class="absolute inset-0 z-[1] flex items-center justify-center transition-opacity duration-700"
            :class="index === current ? 'opacity-100' : 'pointer-events-none opacity-0'"
            :aria-hidden="index !== current"
        >
            <component
                :is="slide.href ? 'a' : 'div'"
                :href="slide.href || undefined"
                class="flex h-full w-full items-center justify-center"
            >
                <img
                    :src="slide.image"
                    :alt="slide.alt"
                    class="max-h-[70vh] w-auto max-w-[88%] object-contain transition-transform duration-500 ease-out hover:scale-[1.08]"
                />
            </component>

            <div
                v-if="slide.name"
                class="pointer-events-none absolute right-4 top-28 max-w-[55%] text-right sm:right-10 md:right-16 md:top-32 lg:max-w-xl"
            >
                <p
                    class="text-2xl font-extrabold leading-tight sm:text-4xl md:text-5xl lg:text-6xl"
                    :class="darkText ? 'text-gray-900' : 'text-white'"
                >
                    {{ slide.name }}
                </p>
                <p v-if="slide.sku" class="mt-2 text-xl font-bold text-brand-cyan sm:text-3xl md:text-4xl">
                    {{ slide.sku }}
                </p>
            </div>

            <p
                v-if="slide.description"
                class="pointer-events-none absolute bottom-20 left-4 max-w-xs text-sm sm:bottom-24 sm:left-10 sm:max-w-md sm:text-base md:left-16"
                :class="darkText ? 'text-gray-700' : 'text-white/90'"
            >
                {{ slide.description }}
            </p>
        </article>

        <template v-if="hasMultiple">
            <button
                type="button"
                class="absolute left-2 top-1/2 z-10 -translate-y-1/2 rounded-full bg-white/80 p-2 text-gray-900 shadow hover:bg-brand-yellow sm:left-4"
                aria-label="Producto anterior"
                @click="prev"
            >
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
            <button
                type="button"
                class="absolute right-2 top-1/2 z-10 -translate-y-1/2 rounded-full bg-white/80 p-2 text-gray-900 shadow hover:bg-brand-yellow sm:right-4"
                aria-label="Producto siguiente"
                @click="next"
            >
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>

            <div class="absolute bottom-6 left-1/2 z-10 flex -translate-x-1/2 gap-2" role="tablist">
                <button
                    v-for="(slide, index) in slides"
                    :key="(slide.sku || slide.alt || index) + '-dot'"
                    type="button"
                    class="h-2.5 w-2.5 rounded-full transition"
                    :class="index === current ? 'bg-brand-red w-8' : 'bg-gray-400'"
                    :aria-label="'Ver ' + (slide.name || slide.alt)"
                    :aria-selected="index === current"
                    @click="goTo(index)"
                />
            </div>
        </template>
    </section>
</template>
