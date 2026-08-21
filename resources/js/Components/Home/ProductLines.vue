<script setup>
import { Link } from '@inertiajs/vue3';

const lines = [
    {
        name: 'Colores estándar',
        color: 'bg-brand-red',
        text: 'La base de todo inventario de globos.',
        image: '/img/productos/estandar.png',
        alt: 'Línea de globos colores estándar Sensacional',
    },
    {
        name: 'Colores Perla y Metálicos',
        color: 'bg-brand-orange',
        text: 'Brillo de anaquel para mayoreo.',
        image: '/img/productos/perla.png',
        alt: 'Línea de globos colores perla y metálicos Sensacional',
    },
    {
        name: 'Colores Cristal y Neón',
        color: 'bg-brand-yellow',
        dark: true,
        text: 'Impacto visual para fiestas y retail.',
        image: '/img/productos/cristal.png',
        alt: 'Línea de globos colores cristal y neón Sensacional',
    },
    {
        name: 'Colores Vintage y fashion',
        color: 'bg-brand-green',
        dark: true,
        text: 'Tendencia para decoradores exigentes.',
        image: '/img/productos/vintage.png',
        alt: 'Línea de globos colores vintage y fashion Sensacional',
    },
    {
        name: 'Tu evento',
        color: 'bg-brand-cyan',
        dark: true,
        text: 'Surtido pensado para celebraciones.',
        image: '/img/productos/evento .png',
        alt: 'Línea de globos para tu evento Sensacional',
    },
    {
        name: 'Nuevo tamaño',
        color: 'bg-brand-purple',
        text: 'Novedad de fábrica para tu catálogo.',
        image: '/img/productos/tamaño.png',
        alt: 'Línea de globos de nuevo tamaño Sensacional',
    },
];
</script>

<template>
    <section class="bg-gray-50 py-16 sm:py-20" aria-labelledby="lineas-titulo">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <p class="text-center text-xs font-bold uppercase tracking-[0.2em] text-brand-red">
                Fabricación propia
            </p>
            <h2 id="lineas-titulo" class="mt-2 text-center text-3xl font-extrabold text-gray-900 sm:text-4xl">
                Líneas de productos
            </h2>
            <p class="mx-auto mt-3 max-w-2xl text-center text-gray-600">
                Todas te llevan a nuestros productos. Envíos a todo México.
            </p>

            <div class="mt-10 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                <article
                    v-for="line in lines"
                    :key="line.name"
                    class="flex h-full flex-col overflow-hidden rounded-2xl bg-white shadow-md transition hover:-translate-y-1 hover:shadow-xl"
                >
                    <div class="flex flex-1 items-center justify-center bg-white p-6">
                        <img
                            :src="line.image"
                            :alt="line.alt"
                            class="mx-auto h-56 w-auto max-w-full object-contain"
                        />
                    </div>
                    <!-- text-gray-900 -->
                    <div
                        :class="[line.color, line.dark ? 'text-white' : 'text-white']"
                        class="px-6 py-5 text-center"
                    >
                        <h3 class="text-2xl font-extrabold">{{ line.name }}</h3>
                        <p class="mt-3 text-sm font-medium opacity-90">{{ line.text }}</p>
                        <Link
                            :href="route('productos')"
                            class="mt-4 inline-flex text-xs font-bold uppercase tracking-wide underline-offset-4 hover:underline"
                        >
                            Ver productos →
                        </Link>
                    </div>
                </article>
            </div>
        </div>
    </section>
</template>
