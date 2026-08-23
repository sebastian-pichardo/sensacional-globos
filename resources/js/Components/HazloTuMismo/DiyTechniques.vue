<script setup>
import { computed, onMounted, onUnmounted, ref } from 'vue';

const techniques = [
    {
        title: 'Guirnaldas y Arcos orgánicos',
        accent: 'bg-brand-red',
        images: [
            { src: '/img/globos/guirnalda-1.webp', alt: 'Guirnalda de globos 1' },
            { src: '/img/globos/guirnalda-2.webp', alt: 'Guirnalda de globos 2' },
            { src: '/img/globos/guirnalda-3.webp', alt: 'Guirnalda de globos 3' },
        ],
    },
    {
        title: 'Paredes de Fondo',
        accent: 'bg-brand-orange',
        images: [
            { src: '/img/globos/backdrops-1.webp', alt: 'Pared de fondo con globos 1' },
            { src: '/img/globos/backdrops-2.webp', alt: 'Pared de fondo con globos 2' },
            { src: '/img/globos/backdrops-3.webp', alt: 'Pared de fondo con globos 3' },
        ],
    },
    {
        title: 'Columnas y Torres Temáticas',
        accent: 'bg-brand-yellow',
        columns: 4,
        images: [
            { src: '/img/globos/torre-tematica-1.webp', alt: 'Torre temática de globos 1' },
            { src: '/img/globos/torre-tematica-2.webp', alt: 'Torre temática de globos 2' },
            { src: '/img/globos/torre-tematica-3.webp', alt: 'Torre temática de globos 3' },
            { src: '/img/globos/torre-tematica-4.webp', alt: 'Torre temática de globos 4' },
        ],
    },
    {
        title: 'Mosaicos de globos',
        accent: 'bg-brand-green',
        images: [
            { src: '/img/globos/mosaico-1.webp', alt: 'Mosaico de globos 1' },
            { src: '/img/globos/mosaico-2.webp', alt: 'Mosaico de globos 2' },
            { src: '/img/globos/mosaico-3.webp', alt: 'Mosaico de globos 3' },
        ],
    },
    {
        title: 'Esculturas en 3D',
        accent: 'bg-brand-cyan',
        images: [
            { src: '/img/globos/escultura-1.webp', alt: 'Escultura 3D de globos 1' },
            { src: '/img/globos/escultura-2.webp', alt: 'Escultura 3D de globos 2' },
            { src: '/img/globos/escultura-3.webp', alt: 'Escultura 3D de globos 3' },
        ],
    },
    {
        title: 'Caída de globos',
        accent: 'bg-brand-purple',
        images: [
            { src: '/img/globos/caida-globo-1.webp', alt: 'Caída de globos 1' },
            { src: '/img/globos/caida-globo-2.webp', alt: 'Caída de globos 2' },
            { src: '/img/globos/caida-globo-3.webp', alt: 'Caída de globos 3' },
        ],
    },
];

const flatImages = computed(() =>
    techniques.flatMap((technique) =>
        technique.images.map((image) => ({
            ...image,
            technique: technique.title,
        })),
    ),
);

const active = ref(null);
const current = computed(() => (active.value === null ? null : flatImages.value[active.value]));

const open = (globalIndex) => {
    active.value = globalIndex;
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
    active.value = (active.value + 1) % flatImages.value.length;
};

const prev = () => {
    if (active.value === null) {
        return;
    }
    active.value = (active.value - 1 + flatImages.value.length) % flatImages.value.length;
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

const globalIndexFor = (techniqueIndex, imageIndex) => {
    let offset = 0;
    for (let i = 0; i < techniqueIndex; i += 1) {
        offset += techniques[i].images.length;
    }
    return offset + imageIndex;
};

const gridClass = (technique) => {
    if (technique.columns === 4) {
        return 'grid-cols-2 md:grid-cols-4';
    }
    return 'grid-cols-1 sm:grid-cols-3';
};

onMounted(() => window.addEventListener('keydown', onKey));
onUnmounted(() => {
    window.removeEventListener('keydown', onKey);
    document.body.style.overflow = '';
});
</script>

<template>
    <section class="bg-white py-16 sm:py-20" aria-labelledby="tecnicas-titulo">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <p class="text-center text-xs font-bold uppercase tracking-[0.2em] text-brand-red">
                Técnicas
            </p>
            <h2 id="tecnicas-titulo" class="mt-2 text-center text-3xl font-extrabold text-gray-900 sm:text-4xl">
                Inspírate y crea
            </h2>
            <p class="mx-auto mt-3 max-w-2xl text-center text-gray-600">
                Mini galerías de cada técnica. Da clic en una foto para verla en grande.
            </p>

            <div class="mt-12 space-y-14">
                <article
                    v-for="(technique, techniqueIndex) in techniques"
                    :key="technique.title"
                >
                    <div class="mb-5 flex items-center gap-3">
                        <span
                            :class="technique.accent"
                            class="h-3 w-3 shrink-0 rounded-full"
                            aria-hidden="true"
                        />
                        <h3 class="text-xl font-extrabold text-gray-900 sm:text-2xl">
                            {{ technique.title }}
                        </h3>
                    </div>

                    <ul class="grid gap-3 md:gap-4" :class="gridClass(technique)">
                        <li
                            v-for="(image, imageIndex) in technique.images"
                            :key="image.src"
                        >
                            <button
                                type="button"
                                class="group relative block w-full overflow-hidden rounded-2xl bg-gray-100 shadow-md focus:outline-none focus:ring-2 focus:ring-brand-cyan focus:ring-offset-2"
                                :aria-label="`Ver en grande: ${image.alt}`"
                                @click="open(globalIndexFor(techniqueIndex, imageIndex))"
                            >
                                <img
                                    :src="image.src"
                                    :alt="image.alt"
                                    class="aspect-[4/3] h-full w-full object-cover transition duration-300 group-hover:scale-105"
                                    loading="lazy"
                                />
                                <span
                                    class="pointer-events-none absolute inset-0 bg-black/0 transition group-hover:bg-black/20"
                                    aria-hidden="true"
                                />
                                <span
                                    class="pointer-events-none absolute bottom-3 left-3 rounded-full bg-black/55 px-2.5 py-1 text-xs font-bold text-white"
                                >
                                    {{ imageIndex + 1 }} / {{ technique.images.length }}
                                </span>
                            </button>
                        </li>
                    </ul>
                </article>
            </div>
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
                <div class="flex max-h-[88vh] max-w-full flex-col items-center">
                    <p class="mb-3 text-center text-sm font-semibold text-white/90">
                        {{ current.technique }}
                    </p>
                    <img
                        :src="current.src"
                        :alt="current.alt"
                        class="max-h-[80vh] max-w-full rounded-xl object-contain shadow-2xl"
                    />
                </div>
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
