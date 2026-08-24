<script setup>
import { computed, onMounted, onUnmounted, ref } from 'vue';

const locations = [
    {
        title: 'Oficina de ventas en Puebla',
        badge: 'Puebla',
        theme: 'bg-brand-cyan',
        ring: 'ring-brand-cyan/40',
        lines: [
            'Camino a Tlaxcalancingo No. 2919',
            'San Andrés Cholula Centro',
            'San Bernardino Tlaxcalancingo',
            'San Andrés Cholula, Puebla, México',
            'C.P. 72810',
        ],
        phone: '+52 222 614 0020',
        tel: '+522226140020',
        mapQuery:
            'Camino a Tlaxcalancingo 2919, San Bernardino Tlaxcalancingo, San Andrés Cholula, Puebla, 72810, México',
    },
    {
        title: 'Fábrica y oficina de ventas',
        badge: 'Jalisco',
        theme: 'bg-brand-orange',
        ring: 'ring-brand-orange/40',
        lines: [
            'Avenida Guadalajara No. 101',
            'Centro Logístico Jalisco',
            'Acatlán de Juárez, Jalisco, México',
            'C.P. 45713',
        ],
        phone: '+52 331 807 8792',
        tel: '+523318078792',
        mapQuery:
            'Avenida Guadalajara 101, Centro Logístico Jalisco, Acatlán de Juárez, Jalisco, 45713, México',
    },
];

const factorySlides = [
    {
        src: '/img/productos/fabrica-1.webp',
        alt: 'Fábrica de Globos Sensacional en Acatlán de Juárez, Jalisco — vista 1',
    },
    {
        src: '/img/productos/fabrica-2.webp',
        alt: 'Fábrica de Globos Sensacional en Acatlán de Juárez, Jalisco — vista 2',
    }
];

const current = ref(0);
const paused = ref(false);
let timer;

const activeSlide = computed(() => factorySlides[current.value] ?? factorySlides[0]);

const next = () => {
    current.value = (current.value + 1) % factorySlides.length;
};

const prev = () => {
    current.value = (current.value - 1 + factorySlides.length) % factorySlides.length;
};

const goTo = (index) => {
    current.value = index;
};

onMounted(() => {
    timer = setInterval(() => {
        if (!paused.value) {
            next();
        }
    }, 5000);
});

onUnmounted(() => {
    clearInterval(timer);
});

const embedUrl = (query) =>
    `https://maps.google.com/maps?q=${encodeURIComponent(query)}&hl=es&z=15&output=embed`;

const mapsLink = (query) =>
    `https://www.google.com/maps/search/?api=1&query=${encodeURIComponent(query)}`;
</script>

<template>
    <section class="relative overflow-hidden bg-brand-yellow/25 py-16 sm:py-20" aria-labelledby="ubicaciones-titulo">
        <div
            class="pointer-events-none absolute -right-10 top-0 h-56 w-56 rounded-full bg-brand-cyan/30 blur-2xl"
            aria-hidden="true"
        />
        <div
            class="pointer-events-none absolute bottom-0 left-0 h-48 w-48 rounded-full bg-brand-orange/30 blur-2xl"
            aria-hidden="true"
        />

        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <p
                class="mx-auto w-fit rounded-full bg-brand-purple px-4 py-1 text-center text-xs font-bold uppercase tracking-[0.2em] text-white"
            >
                En México
            </p>
            <h2
                id="ubicaciones-titulo"
                class="mt-4 text-center text-3xl font-extrabold text-gray-900 sm:text-4xl"
            >
                Ubicaciones
            </h2>
            <p class="mx-auto mt-3 max-w-2xl text-center text-gray-700">
                Visítanos en nuestra oficina de Puebla o en la fábrica de Jalisco.
                Envíos a todo México.
            </p>

            <div class="mt-12 grid gap-8 lg:grid-cols-2">
                <article
                    v-for="place in locations"
                    :key="place.title"
                    class="overflow-hidden rounded-3xl bg-white shadow-xl ring-4"
                    :class="place.ring"
                >
                    <div :class="place.theme" class="flex items-center justify-between px-6 py-4 text-white">
                        <h3 class="text-xl font-extrabold sm:text-2xl">{{ place.title }}</h3>
                        <span class="rounded-full bg-white/20 px-3 py-1 text-xs font-bold uppercase tracking-wide">
                            {{ place.badge }}
                        </span>
                    </div>
                    <div class="p-6 sm:p-8">
                        <address class="not-italic text-gray-700">
                            <p v-for="line in place.lines" :key="line">{{ line }}</p>
                            <p class="mt-4 text-lg font-extrabold text-gray-900">
                                Tel.
                                <a :href="'tel:' + place.tel" class="text-brand-red hover:text-brand-orange">
                                    {{ place.phone }}
                                </a>
                            </p>
                        </address>
                        <a
                            :href="mapsLink(place.mapQuery)"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="mt-5 inline-flex rounded-full bg-gray-900 px-5 py-2 text-xs font-bold uppercase tracking-wide text-white transition hover:bg-brand-red"
                        >
                            Abrir en Google Maps
                        </a>
                    </div>
                    <iframe
                        :src="embedUrl(place.mapQuery)"
                        :title="'Mapa de ' + place.title"
                        class="h-64 w-full border-0 lg:h-80"
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        allowfullscreen
                    />
                </article>
            </div>

            <figure class="mt-12 overflow-hidden rounded-3xl shadow-xl ring-4 ring-brand-purple/30">
                <div
                    class="relative bg-gray-900"
                    aria-roledescription="carousel"
                    aria-label="Galería de la fábrica en Acatlán de Juárez"
                    @mouseenter="paused = true"
                    @mouseleave="paused = false"
                >
                    <!-- Mantiene la altura del carrusel según la imagen activa. -->
                    <img
                        :src="activeSlide.src"
                        alt=""
                        class="pointer-events-none block h-auto w-full opacity-0"
                        aria-hidden="true"
                    />

                    <div
                        v-for="(slide, index) in factorySlides"
                        :key="slide.src"
                        class="absolute inset-0 transition-opacity duration-700"
                        :class="index === current ? 'opacity-100' : 'pointer-events-none opacity-0'"
                        :aria-hidden="index !== current"
                    >
                        <img
                            :src="slide.src"
                            :alt="slide.alt"
                            class="h-full w-full object-cover"
                            :loading="index === 0 ? 'eager' : 'lazy'"
                        />
                    </div>

                    <button
                        type="button"
                        class="absolute left-3 top-1/2 z-10 -translate-y-1/2 rounded-full bg-white/85 p-2 text-gray-900 shadow transition hover:bg-brand-yellow sm:left-4"
                        aria-label="Imagen anterior de la fábrica"
                        @click="prev"
                    >
                        <svg class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <button
                        type="button"
                        class="absolute right-3 top-1/2 z-10 -translate-y-1/2 rounded-full bg-white/85 p-2 text-gray-900 shadow transition hover:bg-brand-yellow sm:right-4"
                        aria-label="Imagen siguiente de la fábrica"
                        @click="next"
                    >
                        <svg class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>

                    <div class="absolute bottom-4 left-1/2 z-10 flex -translate-x-1/2 gap-2" role="tablist">
                        <button
                            v-for="(slide, index) in factorySlides"
                            :key="slide.src + '-dot'"
                            type="button"
                            class="h-2.5 rounded-full transition"
                            :class="index === current ? 'w-8 bg-brand-red' : 'w-2.5 bg-white/75'"
                            :aria-label="'Ver imagen ' + (index + 1) + ' de la fábrica'"
                            :aria-selected="index === current"
                            @click="goTo(index)"
                        />
                    </div>
                </div>
                <figcaption
                    class="bg-gradient-to-r from-brand-purple via-brand-red to-brand-orange px-6 py-4 text-center text-sm font-bold text-white"
                >
                    Fábrica actual de Globos Sensacional · Acatlán de Juárez, Jalisco
                </figcaption>
            </figure>
        </div>
    </section>
</template>
