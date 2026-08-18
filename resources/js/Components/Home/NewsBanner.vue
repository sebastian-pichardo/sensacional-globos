<script setup>
const items = [
    {
        title: 'Nuevas temáticas',
        text: 'Temas importantes para tu inventario de temporada.',
        color: 'bg-brand-red',
        knot: 'border-t-brand-red',
        textColor: 'text-white',
    },
    {
        title: 'El látex no es plástico',
        text: 'Conoce más sobre nuestras acciones sustentables.',
        color: 'bg-brand-green',
        knot: 'border-t-brand-green',
        textColor: 'text-gray-900',
    },
    {
        title: '¡Viva México!',
        text: 'Viva nuestros globos mexicanos. Pide ahora tu surtido tricolor y celebra en grande.',
        color: 'bg-brand-yellow',
        knot: 'border-t-brand-yellow',
        textColor: 'text-gray-900',
    },
    {
        title: 'Decorador sensacional',
        text: 'Inscríbete al programa y recibe grandes sorpresas.',
        color: 'bg-brand-cyan',
        knot: 'border-t-brand-cyan',
        textColor: 'text-gray-900',
    },
    {
        title: 'Familia Sensacional',
        text: 'Si conoces Qualatex, conoces a la familia Sensacional. Fabricamos globos 100% de látex de alta calidad. Envíos a todo México.',
        color: 'bg-brand-purple',
        knot: 'border-t-brand-purple',
        textColor: 'text-white',
    },
];
</script>

<template>
    <section class="bg-white py-16 sm:py-20" aria-labelledby="noticias-titulo">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <p class="text-center text-xs font-bold uppercase tracking-[0.2em] text-brand-orange">
                Novedades para tu negocio
            </p>
            <h2 id="noticias-titulo" class="mt-2 text-center text-3xl font-extrabold text-gray-900 sm:text-4xl">
                Banner de noticias
            </h2>
            <p class="mx-auto mt-3 max-w-2xl text-center text-gray-600">
                Temáticas, fabricación y lanzamientos para distribuidores. Envíos a todo México.
            </p>

            <div class="mt-12 flex flex-wrap items-start justify-center gap-8">
                <article
                    v-for="item in items"
                    :key="item.title"
                    class="flex w-56 flex-col items-center sm:w-64"
                >
                    <div class="news-balloon" :class="[item.color, item.textColor]">
                        <div>
                            <h3 class="text-base font-extrabold sm:text-lg">{{ item.title }}</h3>
                            <p class="mt-2 text-xs font-medium leading-snug sm:text-sm">
                                {{ item.text }}
                            </p>
                        </div>
                    </div>
                    <div class="news-balloon-knot" :class="item.knot" />
                    <div class="news-balloon-string" />
                </article>
            </div>
        </div>
    </section>
</template>
