<script setup>
import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage();
const shipping = computed(() => page.props.brand?.shipping ?? 'Envíos a todo México');
</script>

<template>
    <!-- style="background-image: url('/img/productos/banner-azul.webp')" bg-brand-cyan -->
    <section
        class="bg-brand-orange bg-cover bg-center bg-no-repeat py-16 text-gray-900 text-white sm:py-20"
        
        aria-labelledby="catalogo-titulo"
    >
        <div class="mx-auto max-w-4xl px-4 text-center sm:px-6 lg:px-8">
            <h2 id="catalogo-titulo" class="mt-2 text-3xl font-extrabold drop-shadow-md sm:text-4xl">
                Descarga el catálogo
            </h2>
            <p class="mt-2 text-sm font-semibold font-extrabold">
                Chécate nuestros productos, descarga nuestro catálogo y mantente actualizado.
            </p>
            <!-- <a
                :href="route('catalogo.descargar')"
                class="mt-5 inline-flex items-center"
            >
                <img
                    src="/img/productos/portada-catalogo-2026.webp"
                    alt="Catalogo Globos sensacional 2026"
                    class="mt-4 h-auto w-full rounded-[8px] object-contain"
                />
            </a>
            <p class="mt-6 text-base leading-relaxed sm:text-lg">
                Tenemos más de 30 años de experiencia en la creación de globos 100% biodegradables
                de látex natural, 56 colores divididos en 5 familias, más los diseños especiales.
                ¿Qué esperas para unirte y llevar tu negocio a otro nivel?
            </p> -->
            <div class="mt-5 grid grid-cols-1 items-center gap-8 md:grid-cols-2">
                <!-- Catálogo -->
                <a
                    :href="route('catalogo.descargar')"
                    class="flex justify-center"
                >
                    <img
                        src="/img/productos/portada-catalogo-2026.webp"
                        alt="Catálogo Globos Sensacional 2026"
                        class="h-auto w-full max-w-[400px] rounded-[8px] object-contain"
                    />
                </a>

                <!-- Texto -->
                <div>
                    <p class="text-base leading-relaxed sm:text-lg">
                        Tenemos más de 30 años de experiencia en la creación de globos 100%
                        biodegradables de látex natural, 56 colores divididos en 5 familias,
                        más los diseños especiales. ¿Qué esperas para unirte y llevar tu
                        negocio a otro nivel?
                    </p>
                </div>
            </div>
            <!-- <a
                :href="route('catalogo.descargar')"
                class="mt-8 inline-flex items-center rounded-full bg-brand-red px-8 py-4 text-sm font-bold uppercase tracking-wide text-white shadow-lg transition hover:bg-brand-orange"
            >
                Descarga aquí nuestro catálogo y conócenos
            </a> -->
        </div>
    </section>
</template>
