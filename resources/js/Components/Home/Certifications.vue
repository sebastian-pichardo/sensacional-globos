<script setup>
import { Link } from '@inertiajs/vue3';

const certifications = [
    {
        src: '/img/productos/certificado-crc.png',
        alt: 'Certificación CRC',
    },
    {
        src: '/img/productos/certificado-ema-1.png',
        alt: 'Acreditación EMA',
    },
    {
        src: '/img/productos/certificado-smeta.png',
        alt: 'Certificación Sedex',
    },
];

const ecoHighlights = [
    { label: '100% biodegradables', color: 'bg-brand-green text-white' },
    { label: 'Látex de caucho natural', color: 'bg-brand-yellow text-gray-900' },
    { label: 'Festejo consciente', color: 'bg-brand-cyan text-white' },
];
</script>

<template>
    <section
        class="relative overflow-hidden bg-brand-green py-16 text-gray-900 sm:py-20"
        aria-labelledby="cert-titulo"
    >
        <div
            class="pointer-events-none absolute inset-0 opacity-[0.14]"
            style="
                background-color: #fff;
                -webkit-mask-image: url('/img/productos/latex-biodegradable.svg');
                mask-image: url('/img/productos/latex-biodegradable.svg');
                -webkit-mask-repeat: repeat;
                mask-repeat: repeat;
                -webkit-mask-size: 80px 80px;
                mask-size: 80px 80px;
            "
            aria-hidden="true"
        />
        <div
            class="pointer-events-none absolute -left-16 top-0 h-56 w-56 rounded-full bg-brand-yellow/40 blur-3xl"
            aria-hidden="true"
        />
        <div
            class="pointer-events-none absolute -right-10 bottom-0 h-64 w-64 rounded-full bg-brand-cyan/35 blur-3xl"
            aria-hidden="true"
        />
        <div
            class="pointer-events-none absolute left-1/2 top-1/3 h-40 w-40 -translate-x-1/2 rounded-full bg-white/20 blur-3xl"
            aria-hidden="true"
        />

        <div class="relative z-[1] mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
            <div
                class="rounded-[2rem] bg-gradient-to-br from-white/95 via-white/90 to-brand-yellow/25 p-6 shadow-xl ring-1 ring-white/70 sm:p-10"
            >
                <div class="mx-auto max-w-3xl text-center">
                    <img
                        src="/img/productos/latex-biodegradable100.png"
                        alt="Látex 100% biodegradable"
                        class="mx-auto h-24 w-auto object-contain sm:h-28"
                        loading="lazy"
                    />

                    <p
                        class="mt-5 inline-flex rounded-full bg-brand-green px-4 py-1 text-xs font-bold uppercase tracking-[0.2em] text-white"
                    >
                        Fabricación certificada
                    </p>

                    <h2
                        id="cert-titulo"
                        class="mt-4 text-3xl font-extrabold text-gray-900 sm:text-4xl"
                    >
                        Amigables con el planeta
                    </h2>

                    <p class="mt-3 text-lg font-semibold text-gray-800 sm:text-xl">
                        Nuestro compromiso verde: una celebración Sensacional en un mundo
                        sustentable.
                    </p>

                    <ul class="mt-6 flex flex-wrap justify-center gap-2" aria-label="Beneficios ecológicos">
                        <li
                            v-for="item in ecoHighlights"
                            :key="item.label"
                            :class="item.color"
                            class="rounded-full px-4 py-1.5 text-xs font-bold uppercase tracking-wide sm:text-sm"
                        >
                            {{ item.label }}
                        </li>
                    </ul>

                    <p class="mt-6 text-base leading-relaxed text-gray-700">
                        Fabricamos globos con látex de caucho natural (NRL), vegetal y biodegradable:
                        la opción ideal para festejar sin dejar huella innecesaria. Estamos
                        certificados bajo procesos exigentes que respaldan calidad, responsabilidad
                        social y respeto al entorno. Envíos a todo México.
                    </p>
                </div>

                <div
                    class="mt-8 rounded-3xl bg-brand-green/15 px-4 py-6 ring-1 ring-brand-green/20 sm:px-8"
                >
                    <p class="text-center text-xs font-bold uppercase tracking-[0.2em] text-brand-green">
                        Respaldados por certificaciones
                    </p>
                    <ul
                        class="mx-auto mt-5 flex max-w-3xl flex-wrap items-center justify-center gap-6 sm:gap-10"
                        aria-label="Logos de certificaciones"
                    >
                        <li v-for="cert in certifications" :key="cert.alt">
                            <img
                                :src="cert.src"
                                :alt="cert.alt"
                                class="h-16 w-auto object-contain sm:h-20"
                                loading="lazy"
                            />
                        </li>
                    </ul>
                </div>

                <div class="mt-8 text-center">
                    <Link
                        :href="route('nosotros')"
                        class="inline-flex rounded-full bg-brand-green px-8 py-3 text-sm font-bold uppercase tracking-wide text-white shadow-md transition hover:bg-gray-900"
                    >
                        Conoce más aquí
                    </Link>
                </div>
            </div>
        </div>
    </section>
</template>
