<script setup>
import { usePage } from '@inertiajs/vue3';
import { computed, nextTick, onMounted, onUnmounted, ref, watch } from 'vue';

const page = usePage();
const catalogUrl = computed(
    () => page.props.brand?.catalogViewUrl ?? '/catalogo/2026/Catalogo-Sensacional-2026.php',
);

const colors = [
    {
        name: 'Colores estándar',
        text: 'La base de todo inventario: colores intensos, brillosos y listos para cualquier celebración.',
        image: '/img/productos/globos-colores1.webp',
        alt: 'Ramo de globos de látex en colores estándar Sensacional',
        color: 'bg-brand-red',
        textClass: 'text-white',
    },
    {
        name: 'Colores Perla y Metálicos',
        text: 'Brillo de anaquel y un acabado profesional para mayoreo y decoración de alto impacto.',
        image: '/img/productos/globos-metalico1.webp',
        alt: 'Globos de látex perla y metálicos Sensacional',
        color: 'bg-brand-orange',
        textClass: 'text-white',
    },
    {
        name: 'Colores Cristal y Neón',
        text: 'Transparencias y neones vibrantes para fiestas, retail y activaciones que se notan de lejos.',
        image: '/img/productos/globos-neon1.webp',
        alt: 'Globos de látex cristal y neón Sensacional',
        color: 'bg-brand-yellow',
        textClass: 'text-white',
    },
    {
        name: 'Colores Vintage y fashion',
        text: 'Tonos de tendencia para decoradores que buscan un look sofisticado y actual.',
        image: '/img/productos/globos-vintage1.webp',
        alt: 'Globos de látex vintage y fashion Sensacional',
        color: 'bg-brand-green',
        textClass: 'text-white',
    },
];

const printed = {
    name: 'Globos impresos',
    anchor: 'Nuevo tamaño',
    lead: 'Lleva nuestros globos temáticos y haz de tu evento algo especial. Lleva tu mensaje fuerte y claro.',
    image: '/img/productos/globos-graducion1.webp',
    alt: 'Globos de látex impresos para graduación y ocasiones especiales Sensacional',
    groups: [
        {
            title: 'Impresos',
            items: ['Huellas', 'Manchas de vaca', 'Balón', 'Carita feliz', 'Puntos polka'],
        },
        {
            title: 'Ocasiones especiales',
            items: [
                'Feliz cumpleaños',
                'Nuestra boda',
                'Graduación',
                'Te quiero',
                'Baby shower',
                'Bautizo',
                'Despedida de soltera',
            ],
        },
        {
            title: 'Números divertidos',
            items: ['Del 0 al 9 con puntos polka'],
        },
    ],
};

const seasonal = {
    name: 'Globos de temporada especial',
    anchor: 'Tu evento',
    lead: 'Surtido pensado para las fechas que más se celebran. Pide a tiempo y no te quedes sin inventario.',
    items: [
        {
            label: 'Halloween',
            image: '/img/productos/globos-temporada.webp',
            alt: 'Globos de látex de Halloween Sensacional',
        },
        {
            label: 'Tricolor',
            image: '/img/productos/globos-tricolor.webp',
            alt: 'Globos de látex tricolor Sensacional',
        },
        {
            label: 'Perla Navidad',
            image: '/img/productos/globos-navidad.webp',
            alt: 'Globos de látex perla navidad Sensacional',
        },
    ],
};

const activeSeason = ref(seasonal.items[0]);

const scrollToHash = () => {
    const raw = window.location.hash.replace(/^#/, '');
    if (!raw) {
        return;
    }

    const id = decodeURIComponent(raw);
    const el = document.getElementById(id);
    if (!el) {
        return;
    }

    const offset = 140;
    const top = el.getBoundingClientRect().top + window.scrollY - offset;
    window.scrollTo({ top, behavior: 'smooth' });
};

onMounted(() => {
    nextTick(() => {
        requestAnimationFrame(scrollToHash);
    });
    window.addEventListener('hashchange', scrollToHash);
});

onUnmounted(() => {
    window.removeEventListener('hashchange', scrollToHash);
});

watch(
    () => page.url,
    () => {
        nextTick(() => {
            requestAnimationFrame(scrollToHash);
        });
    },
);

</script>

<template>
    <section class="bg-gray-50 py-16 sm:py-20" aria-labelledby="conoce-productos">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <p class="text-center text-xs font-bold uppercase tracking-[0.2em] text-brand-red">
                Fabricación propia
            </p>
            <h2 id="conoce-productos" class="mt-2 text-center text-3xl font-extrabold text-gray-900 sm:text-4xl">
                Conoce nuestros productos
            </h2>
            <p class="mx-auto mt-3 max-w-2xl text-center text-gray-600">
                Familias de color, impresos temáticos y temporadas especiales. Envíos a todo México.
            </p>

            <div class="mt-10 grid gap-5 sm:grid-cols-2">
                <article
                    v-for="line in colors"
                    :id="line.name"
                    :key="line.name"
                    class="scroll-mt-40 flex h-full flex-col overflow-hidden rounded-2xl bg-white shadow-md transition hover:-translate-y-1 hover:shadow-xl sm:scroll-mt-36"
                >
                    <div class="flex flex-1 items-center justify-center bg-white p-5">
                        <img
                            :src="line.image"
                            :alt="line.alt"
                            class="mx-auto h-56 w-auto max-w-full object-contain"
                        />
                    </div>
                    <div :class="[line.color, line.textClass]" class="px-6 py-5 text-center">
                        <h3 class="text-2xl font-extrabold">{{ line.name }}</h3>
                        <p class="mt-3 text-sm font-medium opacity-90">{{ line.text }}</p>
                        <a
                            :href="catalogUrl"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="mt-5 inline-flex items-center rounded-full bg-white/20 px-5 py-2.5 text-xs font-bold uppercase tracking-wide ring-1 ring-white/50 transition hover:bg-white hover:text-gray-900"
                        >
                            Ver catálogo
                        </a>
                    </div>
                </article>
            </div>

            <article
                :id="printed.anchor"
                class="mt-8 scroll-mt-40 overflow-hidden rounded-3xl bg-white shadow-lg ring-1 ring-black/5 sm:scroll-mt-36 lg:grid lg:grid-cols-2"
            >
                <div class="flex items-center justify-center bg-brand-purple/5 p-6 sm:p-8">
                    <img
                        :src="printed.image"
                        :alt="printed.alt"
                        class="mx-auto max-h-80 w-auto max-w-full object-contain"
                    />
                </div>
                <div class="flex flex-col justify-center p-6 sm:p-8">
                    <span
                        class="inline-flex w-fit rounded-full bg-brand-purple px-3 py-1 text-xs font-bold uppercase tracking-wide text-white"
                    >
                        Nuevo tamaño
                    </span>
                    <h3 class="mt-3 text-3xl font-extrabold text-gray-900">{{ printed.name }}</h3>
                    <p class="mt-3 text-base leading-relaxed text-gray-600">{{ printed.lead }}</p>

                    <div class="mt-6 space-y-4">
                        <div v-for="group in printed.groups" :key="group.title">
                            <p class="text-xs font-bold uppercase tracking-wide text-brand-purple">
                                {{ group.title }}
                            </p>
                            <ul class="mt-2 flex flex-wrap gap-2">
                                <li
                                    v-for="item in group.items"
                                    :key="item"
                                    class="rounded-full bg-gray-100 px-3 py-1 text-sm font-medium text-gray-800"
                                >
                                    {{ item }}
                                </li>
                            </ul>
                        </div>
                    </div>

                    <a
                        :href="catalogUrl"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="mt-8 inline-flex w-fit items-center rounded-full bg-brand-red px-6 py-3 text-sm font-bold uppercase tracking-wide text-white transition hover:bg-brand-orange"
                    >
                        Ver catálogo
                    </a>
                </div>
            </article>

            <article
                :id="seasonal.anchor"
                class="mt-8 scroll-mt-40 overflow-hidden rounded-3xl bg-white shadow-lg ring-1 ring-black/5 sm:scroll-mt-36 lg:grid lg:grid-cols-2"
            >
                <div class="order-2 flex flex-col justify-center p-6 sm:p-8 lg:order-1">
                    <span
                        class="inline-flex w-fit rounded-full bg-brand-orange px-3 py-1 text-xs font-bold uppercase tracking-wide text-white"
                    >
                        Temporada
                    </span>
                    <h3 class="mt-3 text-3xl font-extrabold text-gray-900">{{ seasonal.name }}</h3>
                    <p class="mt-3 text-base leading-relaxed text-gray-600">{{ seasonal.lead }}</p>
                    <div class="mt-5 flex flex-wrap gap-2" role="group" aria-label="Temporadas">
                        <button
                            v-for="item in seasonal.items"
                            :key="item.label"
                            type="button"
                            class="rounded-full px-4 py-1.5 text-sm font-bold transition"
                            :class="
                                activeSeason.label === item.label
                                    ? 'bg-brand-orange text-white shadow-md ring-2 ring-brand-orange/40'
                                    : 'bg-brand-yellow text-white hover:bg-brand-orange hover:text-white'
                            "
                            :aria-pressed="activeSeason.label === item.label"
                            @click="activeSeason = item"
                        >
                            {{ item.label }}
                        </button>
                    </div>
                    <a
                        :href="catalogUrl"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="mt-8 inline-flex w-fit items-center rounded-full bg-brand-red px-6 py-3 text-sm font-bold uppercase tracking-wide text-white transition hover:bg-brand-orange"
                    >
                        Ver catálogo
                    </a>
                </div>
                <div class="order-1 flex items-center justify-center bg-brand-orange/10 p-6 sm:p-8 lg:order-2">
                    <div class="relative flex h-80 w-full items-center justify-center">
                        <Transition
                            enter-active-class="transition duration-300 ease-out"
                            enter-from-class="opacity-0 scale-95"
                            enter-to-class="opacity-100 scale-100"
                            leave-active-class="absolute inset-0 flex items-center justify-center transition duration-200 ease-in"
                            leave-from-class="opacity-100 scale-100"
                            leave-to-class="opacity-0 scale-95"
                            mode="out-in"
                        >
                            <img
                                :key="activeSeason.image"
                                :src="activeSeason.image"
                                :alt="activeSeason.alt"
                                class="mx-auto max-h-80 w-auto max-w-full object-contain"
                            />
                        </Transition>
                    </div>
                </div>
            </article>
        </div>
    </section>
</template>
