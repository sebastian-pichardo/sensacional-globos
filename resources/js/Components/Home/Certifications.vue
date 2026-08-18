<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <section class="relative overflow-hidden bg-brand-green py-16 text-gray-900 sm:py-20" aria-labelledby="cert-titulo">
        <div
            class="pointer-events-none absolute inset-0 opacity-[0.22]"
            style="
                background-color: #fff;
                -webkit-mask-image: url('/img/productos/latex-biodegradable.svg');
                mask-image: url('/img/productos/latex-biodegradable.svg');
                -webkit-mask-repeat: repeat;
                mask-repeat: repeat;
                -webkit-mask-size: 180px 180px;
                mask-size: 180px 180px;
            "
            aria-hidden="true"
        />
        <div class="relative z-[1] mx-auto max-w-4xl px-4 text-center sm:px-6 lg:px-8">
            <p class="text-xs font-bold uppercase tracking-[0.2em]">Fabricación certificada</p>
            <h2 id="cert-titulo" class="mt-2 text-3xl font-extrabold sm:text-4xl">
                Certificaciones
            </h2>
            <p class="mt-3 text-xl font-semibold">
                Nuestro compromiso verde: una celebración Sensacional en un mundo sustentable.
            </p>
            <p class="mt-6 text-base leading-relaxed">
                Estamos certificados bajo los procesos más exigentes y de más alta calidad para la
                fabricación de globos 100% biodegradables, hechos con látex de caucho natural (NRL,
                por sus siglas en inglés), la opción ideal para un festejo consciente. Envíos a todo
                México.
            </p>
            <Link
                :href="route('nosotros')"
                class="mt-8 inline-flex rounded-full bg-gray-900 px-8 py-3 text-sm font-bold uppercase tracking-wide text-white transition hover:bg-brand-purple"
            >
                Conoce más aquí
            </Link>
        </div>
    </section>
</template>
