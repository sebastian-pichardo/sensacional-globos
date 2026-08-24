<script setup>
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
</script>

<template>
    <section
        class="relative overflow-hidden bg-brand-green py-16 text-gray-900 sm:py-20"
        aria-labelledby="verde-titulo"
    >
        <div
            class="pointer-events-none absolute inset-0 opacity-[0.16]"
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
            class="pointer-events-none absolute -left-8 top-8 h-36 w-36 rounded-full bg-brand-yellow/50 blur-2xl"
            aria-hidden="true"
        />
        <div
            class="pointer-events-none absolute -right-8 bottom-8 h-40 w-40 rounded-full bg-brand-cyan/40 blur-2xl"
            aria-hidden="true"
        />

        <div class="relative z-[1] mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
            <p
                class="mx-auto w-fit rounded-full bg-white px-4 py-1 text-center text-xs font-bold uppercase tracking-[0.2em] text-gray-900"
            >
                Fabricación certificada
            </p>
            <h2 id="verde-titulo" class="mt-4 text-center text-3xl font-extrabold sm:text-4xl">
                Nuestro compromiso verde
            </h2>
            <p class="mt-3 text-center text-xl font-semibold">
                Una celebración Sensacional en un mundo sustentable.
            </p>
            <div
                class="mx-auto mt-6 max-w-3xl rounded-3xl bg-white/80 p-6 text-center shadow-md"
            >
                <p class="text-base leading-relaxed">
                    En Sensacional queremos que tengas la mejor de las celebraciones y que al mismo
                    tiempo sea respetuosa con el ambiente. Por ello estamos certificados bajo los
                    procesos más exigentes y de más alta calidad para la fabricación de globos 100%
                    biodegradables, hechos con látex de caucho natural (NRL, por sus siglas en inglés),
                    la opción ideal para un festejo consciente.
                </p>
                <ul
                    class="mt-6 flex flex-nowrap items-center justify-center gap-3 sm:gap-8"
                    aria-label="Logos de certificaciones"
                >
                    <li v-for="cert in certifications" :key="cert.alt" class="min-w-0 flex-1">
                        <img
                            :src="cert.src"
                            :alt="cert.alt"
                            class="mx-auto h-14 w-auto max-w-full object-contain sm:h-20"
                            loading="lazy"
                        />
                    </li>
                </ul>
            </div>

            <h3 class="mt-12 text-center text-2xl font-extrabold">¿Cuál es la diferencia?</h3>

            <div class="mt-8 grid gap-6 md:grid-cols-2">
                <article
                    class="rounded-3xl bg-white p-7 shadow-xl ring-4 ring-brand-yellow/70 transition-transform duration-700 ease-out hover:scale-[1.04]"
                >
                    <span
                        class="inline-flex rounded-full bg-brand-green px-3 py-1 text-xs font-bold uppercase tracking-wide text-gray-900"
                    >
                        La opción Sensacional
                    </span>
                    <h4 class="mt-4 text-2xl font-extrabold text-gray-900">Látex natural</h4>
                    <img
                        src="/img/productos/arbol.svg"
                        alt="El látex natural es vegetal"
                        class="mt-4 h-40 w-full object-contain"
                    />
                    <p class="mt-3 text-lg leading-relaxed text-gray-700">
                        El látex natural es vegetal y biodegradable; amigable con el planeta.
                    </p>
                </article>
                <article
                    class="rounded-3xl bg-brand-red p-7 text-white shadow-xl transition-colors duration-700 ease-out hover:bg-stone-500"
                >
                    <span
                        class="inline-flex rounded-full bg-white/20 px-3 py-1 text-xs font-bold uppercase tracking-wide"
                    >
                        No es nuestro camino
                    </span>
                    <h4 class="mt-4 text-2xl font-extrabold">Plástico</h4>
                    <img
                        src="/img/productos/petroleo.svg"
                        alt="El látex natural es vegetal"
                        class="mt-4 h-40 w-full object-contain"
                    />
                    <p class="mt-3 text-lg leading-relaxed text-white/95">
                        El plástico es un polímero sintético derivado del petróleo, generador de
                        gran contaminación.
                    </p>
                </article>
            </div>

            <div class="mx-auto mt-10 max-w-3xl rounded-3xl bg-brand-yellow p-6 text-center shadow-lg sm:p-8">
                <p class="text-base leading-relaxed text-gray-900">
                    El látex no es plástico. Por esto impulsamos productos obtenidos de procesos
                    sustentables con el medio ambiente y, al mismo tiempo, promovemos una cultura de
                    uso responsable de globos, invitando a distribuidores, clientes y decoradores a
                    generar conciencia para proteger el entorno que compartimos. Garantizamos el uso
                    y la eliminación adecuados de los globos y los productos para celebraciones.
                </p>
                <p class="mt-5 text-lg font-extrabold text-gray-900">
                    En Sensacional, la conservación del medio ambiente es clave para seguir creando
                    decoraciones increíbles sin comprometer el futuro del planeta.
                </p>
            </div>
        </div>
    </section>
</template>
