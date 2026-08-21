<script setup>
const highlights = [
    { label: 'Alta calidad', color: 'bg-brand-red' },
    { label: 'Resistentes y duraderos', color: 'bg-brand-orange' },
    { label: '100% biodegradables', color: 'bg-brand-green' },
    { label: 'Colores intensos', color: 'bg-brand-cyan' },
    { label: 'Acabado profesional', color: 'bg-brand-purple' },
];
</script>

<template>
    <section class="relative overflow-hidden" aria-labelledby="productos-titulo">
        <div
            class="absolute inset-0 bg-gradient-to-br from-brand-cyan/25 via-brand-yellow/20 to-brand-orange/25"
            aria-hidden="true"
        />
        <div
            class="pointer-events-none absolute -left-16 top-10 h-40 w-40 rounded-full bg-brand-red/30 blur-2xl"
            aria-hidden="true"
        />
        <div
            class="pointer-events-none absolute right-0 top-24 h-48 w-48 rounded-full bg-brand-purple/25 blur-2xl"
            aria-hidden="true"
        />
        <div
            class="pointer-events-none absolute bottom-10 left-1/3 h-32 w-32 rounded-full bg-brand-green/40 blur-2xl"
            aria-hidden="true"
        />

        <div class="relative mx-auto max-w-5xl px-4 py-16 sm:px-6 sm:py-20 lg:px-8">
            <div class="text-center">
                <p
                    class="inline-flex rounded-full bg-brand-red px-4 py-1 text-xs font-bold uppercase tracking-[0.2em] text-white"
                >
                    Látex natural
                </p>
                <h1
                    id="productos-titulo"
                    class="mt-4 text-4xl font-extrabold text-gray-900 sm:text-6xl"
                >
                    Productos
                </h1>
                <p class="mx-auto mt-5 max-w-3xl text-lg leading-relaxed text-gray-700 sm:text-xl">
                    Tenemos globos de látex de alta calidad, resistentes y duraderos,
                    <span class="font-semibold text-brand-green">100% biodegradables</span>
                    con colores intensos, brillosos y de un acabado profesional.
                </p>
                <div class="mx-auto mt-6 flex max-w-md justify-center gap-2" aria-hidden="true">
                    <span class="h-3 w-3 rounded-full bg-brand-red" />
                    <span class="h-3 w-3 rounded-full bg-brand-orange" />
                    <span class="h-3 w-3 rounded-full bg-brand-yellow" />
                    <span class="h-3 w-3 rounded-full bg-brand-green" />
                    <span class="h-3 w-3 rounded-full bg-brand-cyan" />
                    <span class="h-3 w-3 rounded-full bg-brand-purple" />
                </div>
                <ul class="mt-8 flex flex-wrap justify-center gap-2">
                    <li
                        v-for="item in highlights"
                        :key="item.label"
                        :class="item.color"
                        class="rounded-full px-4 py-1.5 text-xs font-bold uppercase tracking-wide text-white sm:text-sm"
                    >
                        {{ item.label }}
                    </li>
                </ul>
            </div>
        </div>
    </section>
</template>
