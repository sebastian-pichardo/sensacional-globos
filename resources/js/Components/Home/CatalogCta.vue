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
        aria-labelledby="catalogo-titulo"
    >
        <div class="mx-auto max-w-4xl px-4 text-center sm:px-6 lg:px-8">
            <p class="text-xs font-bold uppercase tracking-[0.2em] text-gray-900/70">
                Para distribuidores
            </p>
            <h2 id="catalogo-titulo" class="mt-2 text-3xl font-extrabold sm:text-4xl">
                Descarga el catálogo
            </h2>
            <p class="mt-6 text-base leading-relaxed sm:text-lg">
                Tenemos más de 30 años de experiencia en la creación de globos 100% biodegradables
                de látex natural, 56 colores divididos en 5 familias, más los diseños especiales.
                ¿Qué esperas para unirte y llevar tu negocio a otro nivel?
            </p>
            <p class="mt-4 text-sm font-semibold">
                Chécate nuestros productos, descarga nuestro catálogo y mantente actualizado.
                {{ shipping }}.
            </p>
            <a
                :href="route('catalogo.descargar')"
                class="mt-8 inline-flex items-center rounded-full bg-brand-red px-8 py-4 text-sm font-bold uppercase tracking-wide text-white shadow-lg transition hover:bg-brand-orange"
            >
                Descarga aquí nuestro catálogo y conócenos
            </a>
        </div>
    </section>
</template>
