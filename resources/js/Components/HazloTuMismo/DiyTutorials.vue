<script setup>
import { computed, ref } from 'vue';

const videos = [
    {
        id: 'j-71Le8G3H4',
        title: 'Tutorial de globos Sensacional 1',
    },
    {
        id: 'FzIdlm6paKo',
        title: 'Tutorial de globos Sensacional 2',
    },
    {
        id: 'UZHW1iWDaSg',
        title: 'Tutorial de globos Sensacional 3',
    },
    {
        id: 'UI3tHfSxNm4',
        title: 'Tutorial de globos Sensacional 4',
    },
];

const perPage = 2;
const page = ref(0);
const totalPages = computed(() => Math.ceil(videos.length / perPage));
const visibleVideos = computed(() => {
    const start = page.value * perPage;
    return videos.slice(start, start + perPage);
});

const next = () => {
    page.value = (page.value + 1) % totalPages.value;
};

const prev = () => {
    page.value = (page.value - 1 + totalPages.value) % totalPages.value;
};

const goTo = (index) => {
    page.value = index;
};
</script>

<template>
    <section class="bg-white py-16 sm:py-20" aria-labelledby="tutoriales-titulo">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-3xl text-center">
                <p class="text-xs font-bold uppercase tracking-[0.2em] text-brand-cyan">
                    Aprende paso a paso
                </p>
                <h2 id="tutoriales-titulo" class="mt-2 text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    Tutoriales de globos
                </h2>
                <p class="mt-5 text-base leading-relaxed text-gray-700 sm:text-lg">
                    Si algo sabemos es que no hay ningún imposible. Así seas un curioso de los
                    globos, o una madre de familia buscando algo bonito en tendencia, todos podemos
                    crear figuras para hacer más bonitas nuestras celebraciones. Sigue estos
                    tutoriales para crear formas y figuras
                    <span class="font-semibold text-brand-red">SENSACIONALES</span>.
                </p>
            </div>

            <div
                class="relative mt-12"
                aria-roledescription="carousel"
                aria-label="Tutoriales de YouTube"
            >
                <div class="grid gap-6 md:grid-cols-2">
                    <article
                        v-for="video in visibleVideos"
                        :key="video.id"
                        class="overflow-hidden rounded-2xl bg-gray-100 shadow-md ring-1 ring-black/5"
                    >
                        <div class="relative aspect-video w-full">
                            <iframe
                                class="absolute inset-0 h-full w-full"
                                :src="`https://www.youtube.com/embed/${video.id}`"
                                :title="video.title"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                referrerpolicy="strict-origin-when-cross-origin"
                                allowfullscreen
                                loading="lazy"
                            />
                        </div>
                    </article>
                </div>

                <div class="mt-8 flex items-center justify-center gap-4">
                    <button
                        type="button"
                        class="rounded-full bg-brand-cyan p-3 text-white shadow transition hover:bg-brand-orange focus:outline-none focus:ring-2 focus:ring-brand-cyan focus:ring-offset-2"
                        aria-label="Tutoriales anteriores"
                        @click="prev"
                    >
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M15 19l-7-7 7-7"
                            />
                        </svg>
                    </button>

                    <div class="flex gap-2" role="tablist" aria-label="Páginas del carrusel">
                        <button
                            v-for="index in totalPages"
                            :key="index"
                            type="button"
                            class="h-2.5 w-2.5 rounded-full transition"
                            :class="page === index - 1 ? 'bg-brand-red scale-110' : 'bg-gray-300 hover:bg-gray-400'"
                            :aria-label="`Ir a la página ${index}`"
                            :aria-current="page === index - 1 ? 'true' : undefined"
                            @click="goTo(index - 1)"
                        />
                    </div>

                    <button
                        type="button"
                        class="rounded-full bg-brand-cyan p-3 text-white shadow transition hover:bg-brand-orange focus:outline-none focus:ring-2 focus:ring-brand-cyan focus:ring-offset-2"
                        aria-label="Tutoriales siguientes"
                        @click="next"
                    >
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M9 5l7 7-7 7"
                            />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </section>
</template>
