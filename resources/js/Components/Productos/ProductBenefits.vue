<script setup>
const benefits = [
    {
        title: 'Publicidad móvil gratuita',
        text: 'Genera miles de impactos visuales con los clientes que toman el globo con tu marca y se desplazan por diversas partes del evento o ciudad.',
        color: 'bg-brand-red',
        icon: 'broadcast',
    },
    {
        title: 'Alto impacto a muy bajo costo',
        text: 'Es uno de los promocionales más económicos por unidad, ofreciendo un excelente retorno de inversión.',
        color: 'bg-brand-orange',
        icon: 'impact',
    },
    {
        title: 'Asociación emocional positiva',
        text: 'El globo es fiesta, diversión y alegría. Asocia tu marca con valores positivos y vuélvete amigable y cercano.',
        color: 'bg-brand-purple',
        icon: 'heart',
    },
    {
        title: 'Punto de atracción',
        text: 'Ideal para que niños, familias y personas en general se acerquen a ver tus productos, se tomen fotos con el souvenir y generen conversación en torno a tu marca o evento.',
        color: 'bg-brand-cyan',
        icon: 'people',
    },
    {
        title: 'Logística sencilla',
        text: 'Ocupan muy poco espacio almacenados desinflados y son fáciles de transportar a cualquier activación.',
        color: 'bg-brand-green',
        icon: 'box',
    },
];
</script>

<template>
    <section class="bg-gray-50 py-16 sm:py-20" aria-labelledby="beneficios-titulo">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <p class="text-center text-xs font-bold uppercase tracking-[0.2em] text-brand-red">
                Marca con globo
            </p>
            <h2 id="beneficios-titulo" class="mt-2 text-center text-3xl font-extrabold text-gray-900 sm:text-4xl">
                Los beneficios de estar con Globos Sensacional
            </h2>
            <p class="mx-auto mt-3 max-w-2xl text-center text-gray-600">
                ¿Cuáles son los beneficios?
            </p>

            <div class="mt-10 grid gap-5 md:grid-cols-2 lg:grid-cols-3">
                <article
                    v-for="benefit in benefits"
                    :key="benefit.title"
                    class="flex h-full flex-col rounded-3xl bg-white p-6 shadow-md ring-1 ring-black/5"
                    :class="benefit.title === 'Logística sencilla' ? 'md:col-span-2 lg:col-span-1' : ''"
                >
                    <span
                        :class="benefit.color"
                        class="inline-flex h-12 w-12 items-center justify-center rounded-2xl text-white"
                    >
                        <svg
                            v-if="benefit.icon === 'broadcast'"
                            class="h-6 w-6"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            aria-hidden="true"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"
                            />
                        </svg>
                        <svg
                            v-else-if="benefit.icon === 'impact'"
                            class="h-6 w-6"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            aria-hidden="true"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"
                            />
                        </svg>
                        <svg
                            v-else-if="benefit.icon === 'heart'"
                            class="h-6 w-6"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            aria-hidden="true"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"
                            />
                        </svg>
                        <svg
                            v-else-if="benefit.icon === 'people'"
                            class="h-6 w-6"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            aria-hidden="true"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"
                            />
                        </svg>
                        <svg
                            v-else
                            class="h-6 w-6"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            aria-hidden="true"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"
                            />
                        </svg>
                    </span>
                    <h3 class="mt-4 text-xl font-extrabold text-gray-900">{{ benefit.title }}</h3>
                    <p class="mt-3 text-sm leading-relaxed text-gray-600">{{ benefit.text }}</p>
                </article>
            </div>
        </div>
    </section>
</template>
