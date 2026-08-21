<script setup>
import { computed, onMounted, onUnmounted, ref } from 'vue';

const images = [
    {
        src: '/img/productos/galeria0.webp',
        alt: 'Marca Sensacional con globos de colores y personaje de celebración',
    },
    {
        src: '/img/productos/galeria1.webp',
        alt: 'Fotografía de producto de globos Sensacional 1',
    },
    {
        src: '/img/productos/galeria2.webp',
        alt: 'Fotografía de producto de globos Sensacional 2',
    },
    {
        src: '/img/productos/galeria3.webp',
        alt: 'Fotografía de producto de globos Sensacional 3',
    },
    {
        src: '/img/productos/galeria4.webp',
        alt: 'Fotografía de producto de globos Sensacional 4',
    },
];

const active = ref(null);
const current = computed(() => (active.value === null ? null : images[active.value]));

const open = (index) => {
    active.value = index;
    document.body.style.overflow = 'hidden';
};

const close = () => {
    active.value = null;
    document.body.style.overflow = '';
};

const next = () => {
    if (active.value === null) {
        return;
    }
    active.value = (active.value + 1) % images.length;
};

const prev = () => {
    if (active.value === null) {
        return;
    }
    active.value = (active.value - 1 + images.length) % images.length;
};

const onKey = (event) => {
    if (active.value === null) {
        return;
    }
    if (event.key === 'Escape') {
        close();
    }
    if (event.key === 'ArrowRight') {
        next();
    }
    if (event.key === 'ArrowLeft') {
        prev();
    }
};

onMounted(() => window.addEventListener('keydown', onKey));
onUnmounted(() => {
    window.removeEventListener('keydown', onKey);
    document.body.style.overflow = '';
});
</script>

<template>
    <section class="bg-white py-16 sm:py-20" aria-labelledby="galeria-titulo">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <p class="text-center text-xs font-bold uppercase tracking-[0.2em] text-brand-red">
                Momentos Sensacionales
            </p>
            <h2 id="galeria-titulo" class="mt-2 text-center text-3xl font-extrabold text-gray-900 sm:text-4xl">
                ¡Vive momentos sensacionales con nosotros!
            </h2>
            <p class="mx-auto mt-3 max-w-2xl text-center text-gray-600">
                Galería de fotografías de producto. Da clic en una imagen para verla en grande.
            </p>

            <ul class="mt-10 grid grid-cols-2 gap-3 md:grid-cols-4 md:gap-4">
                <li
                    v-for="(image, index) in images"
                    :key="image.src"
                    :class="index === 0 ? 'col-span-2 row-span-2' : ''"
                >
                    <button
                        type="button"
                        class="group relative block h-full w-full overflow-hidden rounded-2xl bg-gray-100 shadow-md focus:outline-none focus:ring-2 focus:ring-brand-cyan focus:ring-offset-2"
                        :aria-label="`Ver en grande: ${image.alt}`"
                        @click="open(index)"
                    >
                        <img
                            :src="image.src"
                            :alt="image.alt"
                            class="h-full w-full object-cover transition duration-300 group-hover:scale-105"
                            :class="index === 0 ? 'min-h-64 md:min-h-full' : 'aspect-square'"
                        />
                        <span
                            class="pointer-events-none absolute inset-0 bg-black/0 transition group-hover:bg-black/20"
                            aria-hidden="true"
                        />
                    </button>
                </li>
            </ul>
        </div>

        <Teleport to="body">
            <div
                v-if="current"
                class="fixed inset-0 z-50 flex items-center justify-center bg-black/85 p-4"
                role="dialog"
                aria-modal="true"
                :aria-label="current.alt"
                @click.self="close"
            >
                <button
                    type="button"
                    class="absolute right-4 top-4 rounded-full bg-white/15 p-2 text-white transition hover:bg-white/30"
                    aria-label="Cerrar imagen"
                    @click="close"
                >
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"
                        />
                    </svg>
                </button>
                <button
                    type="button"
                    class="absolute left-3 top-1/2 -translate-y-1/2 rounded-full bg-white/15 p-3 text-white transition hover:bg-white/30 sm:left-6"
                    aria-label="Imagen anterior"
                    @click="prev"
                >
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M15 19l-7-7 7-7"
                        />
                    </svg>
                </button>
                <img
                    :src="current.src"
                    :alt="current.alt"
                    class="max-h-[88vh] max-w-full rounded-xl object-contain shadow-2xl"
                />
                <button
                    type="button"
                    class="absolute right-3 top-1/2 -translate-y-1/2 rounded-full bg-white/15 p-3 text-white transition hover:bg-white/30 sm:right-6"
                    aria-label="Imagen siguiente"
                    @click="next"
                >
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M9 5l7 7-7 7"
                        />
                    </svg>
                </button>
            </div>
        </Teleport>
    </section>
</template>
