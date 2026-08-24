<template>
    <section
        class="relative overflow-hidden bg-white py-16 sm:py-20"
        aria-labelledby="trabajos-titulo"
    >
        <div
            class="absolute inset-0 bg-gradient-to-b from-brand-yellow/10 via-transparent to-brand-cyan/10"
            aria-hidden="true"
        />
        <div
            class="pointer-events-none absolute -left-12 top-16 h-40 w-40 rounded-full bg-brand-orange/20 blur-2xl"
            aria-hidden="true"
        />
        <div
            class="pointer-events-none absolute -right-12 bottom-12 h-44 w-44 rounded-full bg-brand-purple/20 blur-2xl"
            aria-hidden="true"
        />

        <div class="relative mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
            <p class="text-center text-xs font-bold uppercase tracking-[0.2em] text-brand-purple">
                Comunidad Sensacional
            </p>
            <h2 id="trabajos-titulo" class="mt-2 text-center text-3xl font-extrabold text-gray-900 sm:text-4xl">
                Ellos ya son parte de esta gran comunidad
            </h2>

            <div
                class="mt-12 flex min-h-[220px] flex-col items-center justify-center rounded-3xl border-2 border-dashed border-brand-cyan/50 bg-gradient-to-br from-brand-cyan/10 via-white to-brand-purple/10 px-6 py-14 text-center"
            >
                <div class="mb-4 flex gap-2" aria-hidden="true">
                    <span class="h-3 w-3 rounded-full bg-brand-red" />
                    <span class="h-3 w-3 rounded-full bg-brand-orange" />
                    <span class="h-3 w-3 rounded-full bg-brand-yellow" />
                    <span class="h-3 w-3 rounded-full bg-brand-green" />
                    <span class="h-3 w-3 rounded-full bg-brand-cyan" />
                    <span class="h-3 w-3 rounded-full bg-brand-purple" />
                </div>
                <p class="text-xl font-extrabold text-gray-900 sm:text-2xl">
                    ¡Aquí aparecerán tus mejores trabajos!
                </p>
                <p class="mt-3 max-w-md text-sm text-gray-600 sm:text-base">
                    Pronto mostraremos las creaciones de la comunidad con sus créditos
                    correspondientes.
                </p>
            </div>
        </div>
    </section>
</template>
