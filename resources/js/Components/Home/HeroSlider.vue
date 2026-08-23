<script setup>
import { computed, onMounted, onUnmounted, ref } from 'vue';

const props = defineProps({
    slides: {
        type: Array,
        required: true,
    },
});

const current = ref(0);
const paused = ref(false);
let timer;

const hasMultiple = computed(() => props.slides.length > 1);
const activeSlide = computed(() => props.slides[current.value] ?? props.slides[0]);

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

onMounted(() => {
    window.addEventListener('keydown', onKey);
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
        class="relative w-full overflow-hidden bg-black"
        aria-roledescription="carousel"
        aria-label="Productos destacados"
        @mouseenter="paused = true"
        @mouseleave="paused = false"
    >
        <h1 class="sr-only">
            Globos Sensacionales: fabricación de globos de látex para distribuidores en todo México
        </h1>

        <!-- Define la altura del slider según la imagen activa (sin recortar). -->
        <picture
            v-if="activeSlide"
            class="pointer-events-none block w-full opacity-0"
            aria-hidden="true"
        >
            <source
                v-if="activeSlide.imageMobile"
                media="(max-width: 767px)"
                :srcset="activeSlide.imageMobile"
            />
            <img
                :src="activeSlide.image"
                alt=""
                class="block h-auto w-full"
            />
        </picture>

        <article
            v-for="(slide, index) in slides"
            :key="slide.sku || slide.alt || index"
            class="absolute inset-0 flex items-center justify-center transition-opacity duration-700"
            :class="index === current ? 'opacity-100' : 'pointer-events-none opacity-0'"
            :aria-hidden="index !== current"
        >
            <component
                :is="slide.href ? 'a' : 'div'"
                :href="slide.href || undefined"
                class="flex h-full w-full items-center justify-center"
            >
                <picture class="block h-full w-full">
                    <source
                        v-if="slide.imageMobile"
                        media="(max-width: 767px)"
                        :srcset="slide.imageMobile"
                    />
                    <img
                        :src="slide.image"
                        :alt="slide.alt"
                        class="mx-auto h-full w-full object-contain object-center"
                        :loading="index === 0 ? 'eager' : 'lazy'"
                        :fetchpriority="index === 0 ? 'high' : undefined"
                    />
                </picture>
            </component>

            <div
                v-if="slide.name"
                class="pointer-events-none absolute right-4 top-28 z-[1] max-w-[55%] text-right sm:right-10 md:right-16 md:top-32 lg:max-w-xl"
            >
                <p class="text-2xl font-extrabold leading-tight text-white sm:text-4xl md:text-5xl lg:text-6xl">
                    {{ slide.name }}
                </p>
                <p v-if="slide.sku" class="mt-2 text-xl font-bold text-brand-cyan sm:text-3xl md:text-4xl">
                    {{ slide.sku }}
                </p>
            </div>

            <p
                v-if="slide.description"
                class="pointer-events-none absolute bottom-20 left-4 z-[1] max-w-xs text-sm text-white/90 sm:bottom-24 sm:left-10 sm:max-w-md sm:text-base md:left-16"
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
                    :class="index === current ? 'bg-brand-red w-8' : 'bg-white/70'"
                    :aria-label="'Ver ' + (slide.name || slide.alt)"
                    :aria-selected="index === current"
                    @click="goTo(index)"
                />
            </div>
        </template>
    </section>
</template>
