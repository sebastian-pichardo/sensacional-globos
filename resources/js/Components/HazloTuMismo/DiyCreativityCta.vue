<script setup>
import { Link } from '@inertiajs/vue3';
import DiyArchColorPicker from '@/Components/HazloTuMismo/DiyArchColorPicker.vue';

defineProps({
    lineasColor: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <section
        class="relative overflow-hidden bg-gray-50 py-16 sm:py-20"
        aria-labelledby="creatividad-titulo"
    >
        <div
            class="pointer-events-none absolute -right-16 top-8 h-48 w-48 rounded-full bg-brand-purple/15 blur-2xl"
            aria-hidden="true"
        />
        <div
            class="pointer-events-none absolute -left-10 bottom-8 h-40 w-40 rounded-full bg-brand-cyan/20 blur-2xl"
            aria-hidden="true"
        />

        <div class="relative mx-auto max-w-6xl px-4 text-center sm:px-6 lg:px-8">
            <p class="text-xs font-bold uppercase tracking-[0.2em] text-brand-purple">
                Sin límites
            </p>
            <h2 id="creatividad-titulo" class="mt-2 text-3xl font-extrabold text-gray-900 sm:text-4xl">
                Y muchas más
            </h2>
            <p class="mx-auto mt-5 max-w-3xl text-base leading-relaxed text-gray-700 sm:text-lg">
                El límite es tu creatividad. Puedes inspirarte de otros profesionales: echa un
                vistazo a ideas, tendencias y combinaciones que elevan cualquier celebración.
            </p>
            <Link
                :href="route('inspirate')"
                class="mt-8 inline-flex items-center rounded-full bg-brand-purple px-8 py-4 text-sm font-bold uppercase tracking-wide text-white shadow-lg transition hover:bg-brand-red"
            >
                Inspírate
            </Link>

            <DiyArchColorPicker :lineas-color="lineasColor" />
        </div>
    </section>
</template>
