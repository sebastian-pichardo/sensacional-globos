<script setup>
const chapters = [
    {
        accent: 'bg-brand-cyan',
        badge: 'bg-brand-cyan',
        label: 'Origen',
        text: 'Esta historia escrita con aire, color y momentos excepcionales inicia hace más de 30 años con Pioneer Balloon México, un experto en la creación de globos de látex 100% biodegradables. A través de sus productos llevó alegría a millones de familias, personas y decoradores. Con este ejército, logró conquistar territorios enteros en diversos países, especialmente en América. Su marca estrella, Qualatex, se convirtió en el estándar de oro que enseñó a volar a los decoradores y artistas del globo en todo el mundo.',
    },
    {
        accent: 'bg-brand-orange',
        badge: 'bg-brand-orange',
        label: 'La pausa',
        text: 'Pero incluso los mejores sueños enfrentan tormentas. Los tiempos difíciles llevaron a cerrar un capítulo de este libro y, aunque las máquinas parecieron detenerse, el destino aún no había hecho el nudo final de esta historia. Algo maravilloso ocurrió: un grupo de inversionistas con visión y temple vio en aquella pausa una llama que aún se negaba a extinguirse.',
    },
    {
        accent: 'bg-brand-purple',
        badge: 'bg-brand-purple',
        label: 'Renacimiento',
        text: 'Sensacional renació de este suceso, no bajo el peso del pasado, sino con una identidad renovada, viva y vibrante. Rescatando la herencia de décadas de conocimiento, la maestría técnica y el alma de los maestros del látex.',
    },
    {
        accent: 'bg-brand-red',
        badge: 'bg-brand-red',
        label: 'Hoy',
        text: 'Hoy se alza como la prueba viviente de que la verdadera calidad no desaparece, solo se transforma. Con autonomía, pasión renovada y la misma excelencia técnica en sus venas, Globos Sensacional vuelve a llenar los cielos de color. Porque las grandes historias, igual que los mejores globos, siempre encuentran la forma de elevarse muy alto.',
    },
];
</script>

<template>
    <section class="relative overflow-hidden" aria-labelledby="historia-titulo">
        <div
            class="absolute inset-0 bg-gradient-to-br from-brand-cyan/25 via-brand-yellow/20 to-brand-orange/25"
            aria-hidden="true"
        />
        <div
            class="pointer-events-none absolute -left-16 top-10 h-40 w-40 rounded-full bg-brand-red/30 blur-2xl"
            aria-hidden="true"
        />
        <div
            class="pointer-events-none absolute right-0 top-24 h-48 w-48 rounded-full bg-brand-purple/25 blur-2xl"
            aria-hidden="true"
        />
        <div
            class="pointer-events-none absolute bottom-10 left-1/3 h-32 w-32 rounded-full bg-brand-green/40 blur-2xl"
            aria-hidden="true"
        />

        <div class="relative mx-auto max-w-5xl px-4 py-16 sm:px-6 sm:py-20 lg:px-8">
            <div class="text-center">
                <p
                    class="inline-flex rounded-full bg-brand-red px-4 py-1 text-xs font-bold uppercase tracking-[0.2em] text-white"
                >
                    Más de 30 años
                </p>
                <h1
                    id="historia-titulo"
                    class="mt-4 text-4xl font-extrabold text-gray-900 sm:text-6xl"
                >
                    Nosotros
                </h1>
                <p class="mx-auto mt-4 max-w-2xl text-lg font-semibold text-gray-800 sm:text-xl">
                    Una historia escrita con
                    <span class="text-brand-red">aire</span>,
                    <span class="text-brand-orange">color</span>
                    y
                    <span class="text-brand-purple">momentos excepcionales</span>.
                </p>
                <div class="mx-auto mt-6 flex max-w-md justify-center gap-2" aria-hidden="true">
                    <span class="h-3 w-3 rounded-full bg-brand-red" />
                    <span class="h-3 w-3 rounded-full bg-brand-orange" />
                    <span class="h-3 w-3 rounded-full bg-brand-yellow" />
                    <span class="h-3 w-3 rounded-full bg-brand-green" />
                    <span class="h-3 w-3 rounded-full bg-brand-cyan" />
                    <span class="h-3 w-3 rounded-full bg-brand-purple" />
                </div>
            </div>

            <div class="mt-12 grid gap-5">
                <article
                    v-for="chapter in chapters"
                    :key="chapter.label"
                    class="overflow-hidden rounded-3xl bg-white/90 shadow-lg ring-1 ring-black/5 backdrop-blur"
                >
                    <div class="flex">
                        <div :class="chapter.accent" class="w-2 shrink-0 sm:w-3" />
                        <div class="p-6 sm:p-8">
                            <span
                                :class="chapter.badge"
                                class="inline-flex rounded-full px-3 py-1 text-xs font-bold uppercase tracking-wide text-white"
                            >
                                {{ chapter.label }}
                            </span>
                            <p class="mt-4 text-base leading-relaxed text-gray-700 sm:text-lg">
                                {{ chapter.text }}
                            </p>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </section>
</template>
