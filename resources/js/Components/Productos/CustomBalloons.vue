<script setup>
import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage();
const quoteUrl = computed(() => {
    const number = page.props.brand?.whatsapp ?? '5210000000000';
    const text =
        'Hola, quiero una cotización exprés de globos personalizados con logo. Tamaños 9" y 12". Envíos a todo México.';

    return `https://wa.me/${number}?text=${encodeURIComponent(text)}`;
});

const steps = [
    {
        number: '1',
        color: 'bg-brand-red',
        title: 'Elige tu tamaño',
        text: '9" o 12". El formato ideal para tu activación, evento o campaña.',
    },
    {
        number: '2',
        color: 'bg-brand-orange',
        title: 'Elige logo y color',
        text: 'El logo a imprimir y el color de tu globo de látex. Pueden ser colores combinados de 9" y 12".',
    },
    {
        number: '3',
        color: 'bg-brand-purple',
        title: 'Cotización exprés',
        text: 'Escríbenos y te armamos una cotización rápida con un representante de ventas.',
    },
];
</script>

<template>
    <section class="relative overflow-hidden bg-white py-16 sm:py-20" aria-labelledby="personalizados-titulo">
        <div
            class="pointer-events-none absolute -right-16 top-10 h-48 w-48 rounded-full bg-brand-cyan/20 blur-2xl"
            aria-hidden="true"
        />
        <div
            class="pointer-events-none absolute -left-10 bottom-10 h-40 w-40 rounded-full bg-brand-purple/15 blur-2xl"
            aria-hidden="true"
        />

        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-3xl text-center">
                <p class="text-xs font-bold uppercase tracking-[0.2em] text-brand-purple">
                    Impresión con logo
                </p>
                <h2 id="personalizados-titulo" class="mt-2 text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    Globos personalizados
                </h2>
                <p class="mt-4 text-lg font-semibold text-gray-800">
                    Te ayudamos a crecer: ponle tu logo a nuestros globos y crezcamos juntos.
                </p>
                <p class="mt-3 text-base leading-relaxed text-gray-600">
                    Haz que tu evento, campaña o activación tenga una presencia profesional y genera
                    miles de impactos visuales en tus clientes. Lleva tu promoción al siguiente nivel.
                </p>
            </div>

            <h3 class="mt-12 text-center text-xl font-extrabold text-gray-900">
                ¿Cómo puedes realizarlo?
            </h3>

            <ol class="mt-8 grid gap-5 lg:grid-cols-3">
                <li
                    v-for="step in steps"
                    :key="step.number"
                    class="relative rounded-3xl bg-gray-50 p-6 shadow-sm ring-1 ring-black/5"
                >
                    <span
                        :class="step.color"
                        class="inline-flex h-10 w-10 items-center justify-center rounded-full text-lg font-extrabold text-white"
                    >
                        {{ step.number }}
                    </span>
                    <h4 class="mt-4 text-xl font-extrabold text-gray-900">{{ step.title }}</h4>
                    <p class="mt-2 text-sm leading-relaxed text-gray-600">{{ step.text }}</p>
                </li>
            </ol>

            <div class="mt-10 rounded-3xl bg-brand-cyan/15 p-6 text-center sm:p-8">
                <p class="text-base font-semibold text-gray-800 sm:text-lg">
                    Escríbenos para una cotización exprés
                </p>
                <a
                    :href="quoteUrl"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="mt-5 inline-flex items-center rounded-full bg-brand-red px-8 py-3.5 text-sm font-bold uppercase tracking-wide text-white shadow-lg transition hover:bg-brand-orange"
                >
                    Click aquí
                </a>
                <p class="mt-4 text-xs text-gray-600 sm:text-sm">
                    *Consulta disponibilidad de impresión y colores con un representante de ventas.
                </p>
            </div>
        </div>
    </section>
</template>
