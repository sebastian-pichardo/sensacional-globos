<template>
    <section class="relative overflow-hidden" aria-labelledby="inspirate-titulo">
        <div
            class="absolute inset-0 bg-gradient-to-br from-brand-purple/20 via-brand-cyan/20 to-brand-orange/25"
            aria-hidden="true"
        />
        <div
            class="pointer-events-none absolute -left-16 top-10 h-40 w-40 rounded-full bg-brand-red/30 blur-2xl"
            aria-hidden="true"
        />
        <div
            class="pointer-events-none absolute right-0 top-24 h-48 w-48 rounded-full bg-brand-purple/30 blur-2xl"
            aria-hidden="true"
        />
        <div
            class="pointer-events-none absolute bottom-10 left-1/3 h-32 w-32 rounded-full bg-brand-yellow/40 blur-2xl"
            aria-hidden="true"
        />

        <div class="relative mx-auto max-w-6xl px-4 py-12 sm:px-6 sm:py-16 lg:px-8 lg:py-20">
            <div class="text-center">
                <p
                    class="inline-flex rounded-full bg-brand-purple px-4 py-1 text-xs font-bold uppercase tracking-[0.2em] text-white"
                >
                    Comunidad
                </p>
                <h1
                    id="inspirate-titulo"
                    class="mt-4 text-4xl font-extrabold text-gray-900 sm:text-5xl lg:text-6xl"
                >
                    Decoradores sensacionales
                </h1>
                <div class="mx-auto mt-6 flex max-w-md justify-center gap-2" aria-hidden="true">
                    <span class="h-3 w-3 rounded-full bg-brand-red" />
                    <span class="h-3 w-3 rounded-full bg-brand-orange" />
                    <span class="h-3 w-3 rounded-full bg-brand-yellow" />
                    <span class="h-3 w-3 rounded-full bg-brand-green" />
                    <span class="h-3 w-3 rounded-full bg-brand-cyan" />
                    <span class="h-3 w-3 rounded-full bg-brand-purple" />
                </div>
            </div>

            <div
                class="mx-auto mt-10 w-full max-w-[400px] overflow-hidden rounded-3xl shadow-xl ring-4 ring-white/80"
            >
                <img
                    src="/img/productos/globossensacional-inspirate.png"
                    alt="Decoradores y artistas del globo de la comunidad Globos Sensacionales"
                    class="aspect-square h-auto w-full object-cover object-center"
                    width="400"
                    height="400"
                    loading="eager"
                    decoding="async"
                />
            </div>
        </div>
    </section>
</template>
