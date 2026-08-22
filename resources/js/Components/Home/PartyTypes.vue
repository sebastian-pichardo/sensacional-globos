<script setup>
import { Link } from '@inertiajs/vue3';

const types = [
    {
        title: 'El artista',
        audience: 'Decoradores y artistas del globo',
        image: '/img/productos/artista.png',
        text: 'Tiene creatividad al máximo, sabe lo que quiere y va por ello. Tú lo piensas y nuestros globos lo hacen realidad.',
        cta: 'Click aquí',
        route: 'inspirate',
        color: 'border-brand-purple',
        badge: 'bg-brand-purple',
    },
    {
        title: 'El empresario',
        audience: 'Distribuidores y mayoristas',
        image: '/img/productos/empresario.png',
        text: 'Los números no son un lenguaje ajeno para ti: manejas las ganancias, los libros contables y las ventas al día, con mucha seguridad y pasión.',
        cta: 'Click aquí',
        route: 'encuentra-un-distribuidor',
        color: 'border-brand-orange',
        badge: 'bg-brand-orange',
    },
    {
        title: 'El 14 oficios',
        audience: 'Curiosos y creadores de tutoriales',
        image: '/img/productos/distribuidor.png',
        text: 'Tú solito contra el mundo, curioso e investigador. Si tienes internet, tú puedes resolverlo todo. Hazlo tú mismo es tu categoría favorita.',
        cta: 'Click aquí',
        route: 'hazlo-tu-mismo',
        color: 'border-brand-cyan',
        badge: 'bg-brand-cyan',
    },
];
</script>

<template>
    <section class="bg-white py-16 sm:py-20" aria-labelledby="fiestero-titulo">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <h2 id="fiestero-titulo" class="text-center text-3xl font-extrabold text-gray-900 sm:text-4xl">
                Tipo de fiestero
            </h2>
            <p class="mx-auto mt-4 max-w-3xl text-center text-gray-600">
                En Sensacional sabemos que las celebraciones, las fiestas y los eventos se viven en
                familia. ¿Qué tipo de fiestero nos visita hoy? Click para conocer más en tu tipo de
                fiestero.
            </p>

            <div class="mt-10 grid gap-6 lg:grid-cols-3">
                <article
                    v-for="type in types"
                    :key="type.title"
                    class="flex flex-col rounded-2xl border-t-8 bg-gray-50 p-6 shadow-sm"
                    :class="type.color"
                >
                    <span
                        class="inline-flex w-fit rounded-full px-3 py-1 text-xs font-bold uppercase tracking-wide text-white"
                        :class="type.badge"
                    >
                        {{ type.audience }}
                    </span>
                    <img
                        v-if="type.image"
                        :src="type.image"
                        :alt="type.title"
                        class="mt-4 h-40 w-full object-contain"
                    />
                    <h3 class="mt-4 text-2xl font-extrabold text-gray-900">{{ type.title }}</h3>
                    <p class="mt-3 flex-1 text-sm leading-relaxed text-gray-600">{{ type.text }}</p>
                    <Link
                        :href="route(type.route)"
                        class="mt-6 inline-flex text-sm font-bold uppercase tracking-wide text-brand-red hover:text-brand-orange"
                    >
                        {{ type.cta }} →
                    </Link>
                </article>
            </div>
        </div>
    </section>
</template>
