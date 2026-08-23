<script setup>
import { Link } from '@inertiajs/vue3';

const certifications = [
    {
        src: '/img/productos/certificacion-crc-nueva.png',
        alt: 'Certificación CRC',
    },
    {
        src: '/img/productos/certificacion-sedex-nuevas.png',
        alt: 'Certificación Sedex',
    },
    {
        src: '/img/productos/certificacion-ema-nuevo.png',
        alt: 'Acreditación EMA',
    },
];
</script>

<template>
    <section class="relative overflow-hidden bg-[#388E3C] py-16 text-white sm:py-20" aria-labelledby="cert-titulo">

        <div class="relative z-[1] mx-auto max-w-4xl px-4 text-center sm:px-6 lg:px-8">
            <p class="text-xs font-bold uppercase tracking-[0.2em]">Fabricación certificada</p>
            <h2 id="cert-titulo" class="mt-2 text-3xl font-extrabold sm:text-4xl">
                Certificaciones
            </h2>
            <p class="mt-3 text-xl font-semibold">
                Nuestro compromiso verde: una celebración Sensacional en un mundo sustentable.
            </p>

            <ul
                class="mx-auto mt-8 flex max-w-3xl flex-wrap items-center justify-center gap-6 sm:gap-10"
                aria-label="Logos de certificaciones"
            >
                <li v-for="cert in certifications" :key="cert.alt">
                    <img
                        :src="cert.src"
                        :alt="cert.alt"
                        class="h-20 w-auto object-contain sm:h-24"
                        loading="lazy"
                    />
                </li>
            </ul>

            <p class="mt-8 text-base leading-relaxed">
                Estamos certificados bajo los procesos más exigentes y de más alta calidad para la
                fabricación de globos 100% biodegradables, hechos con látex de caucho natural (NRL,
                por sus siglas en inglés), la opción ideal para un festejo consciente. Envíos a todo
                México.
            </p>
            <Link
                :href="route('nosotros')"
                class="mt-8 inline-flex rounded-full bg-brand-red px-8 py-3 text-sm font-bold uppercase tracking-wide text-white transition hover:bg-brand-purple"
            >
                Conoce más aquí
            </Link>
        </div>
    </section>
</template>
