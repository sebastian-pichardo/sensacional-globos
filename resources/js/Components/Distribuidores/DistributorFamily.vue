<script setup>
const benefits = [
    {
        title: 'Productos de calidad premium',
        color: 'bg-brand-red',
    },
    {
        title: 'Excelente rotación y vida de anaquel',
        color: 'bg-brand-orange',
    },
    {
        title: 'Abasto confiable, inventario constante y entregas puntuales',
        color: 'bg-brand-cyan',
    },
    {
        title: 'El respaldo de una marca sólida y de gran confianza',
        color: 'bg-brand-purple',
    },
    {
        title: 'Envíos a todo México',
        color: 'bg-brand-green',
    },
];
</script>

<template>
    <section class="bg-gray-50 py-16 sm:py-20" aria-labelledby="familia-titulo">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
            <p class="text-center text-xs font-bold uppercase tracking-[0.2em] text-brand-red">
                Familia Sensacional
            </p>
            <h2 id="familia-titulo" class="mt-2 text-center text-3xl font-extrabold text-gray-900 sm:text-4xl">
                ¿Y tú qué esperas para ser parte de esta gran familia Sensacional?
            </h2>
            <p class="mx-auto mt-5 max-w-3xl text-center text-base leading-relaxed text-gray-700 sm:text-lg">
                Si conoces Qualatex entonces ya nos conoces. Heredamos la maestría técnica para la
                creación de globos de látex y resurgimos como una empresa mexicana con gran
                compromiso hacia nuestro público.
            </p>
            <p class="mx-auto mt-6 max-w-3xl text-center text-lg font-semibold text-gray-900">
                Compra ahora y elígenos como socios. Colaboremos con:
            </p>

            <ul class="mt-8 grid gap-4 sm:grid-cols-2">
                <li
                    v-for="benefit in benefits"
                    :key="benefit.title"
                    class="flex items-start gap-3 rounded-2xl bg-white p-5 shadow-sm ring-1 ring-black/5"
                    :class="benefit.title === 'Envíos a todo México' ? 'sm:col-span-2' : ''"
                >
                    <span
                        :class="benefit.color"
                        class="mt-0.5 inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-full text-white"
                    >
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2.5"
                                d="M5 13l4 4L19 7"
                            />
                        </svg>
                    </span>
                    <span class="font-semibold text-gray-800">{{ benefit.title }}</span>
                </li>
            </ul>

            <p class="mx-auto mt-8 max-w-3xl text-center text-base leading-relaxed text-gray-700">
                Aprovecha la oportunidad de incrementar tus ganancias con un excelente precio.
            </p>
            <p class="mt-3 text-center text-2xl font-extrabold uppercase tracking-wide text-brand-red sm:text-3xl">
                ¡Hagamos cosas SENSACIONALES juntos!
            </p>
        </div>
    </section>
</template>
