<script setup>
import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage();
const shipping = computed(() => page.props.brand?.shipping ?? 'Envíos a todo México');
</script>

<template>
    <section
        class="bg-brand-cyan bg-cover bg-center bg-no-repeat py-16 text-gray-900 sm:py-20"
        style="background-image: url('/img/productos/banner-azul.webp')"
        aria-labelledby="descarga-catalogo"
    >
        <div class="mx-auto max-w-4xl px-4 text-center sm:px-6 lg:px-8">
            <p class="text-xs font-bold uppercase tracking-[0.2em] text-gray-900/70">
                Catálogo 2026
            </p>
            <h2 id="descarga-catalogo" class="mt-2 text-3xl font-extrabold sm:text-4xl">
                Descarga nuestro catálogo
            </h2>
            <p class="mt-6 text-base leading-relaxed sm:text-lg">
                Obtén toda la información necesaria para tener un evento sensacional.
                {{ shipping }}.
            </p>
            <a
                :href="route('catalogo.descargar')"
                class="mt-8 inline-flex items-center rounded-full bg-brand-red px-8 py-4 text-sm font-bold uppercase tracking-wide text-white shadow-lg transition hover:bg-brand-orange"
            >
                Descargar catálogo
            </a>
        </div>
    </section>
</template>
