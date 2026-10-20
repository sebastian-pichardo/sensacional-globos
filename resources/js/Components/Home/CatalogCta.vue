<script setup>
import { usePage } from '@inertiajs/vue3';
import { computed, onMounted, onUnmounted, ref } from 'vue';

const page = usePage();
const csrf = computed(() => page.props.csrf_token || '');
const emailError = computed(() => page.props.errors?.email || '');
const seasonalError = computed(() => page.props.flash?.seasonal_catalog || '');
const abierto = ref(false);
const catalogo = ref('general');

const titulo = computed(() =>
    catalogo.value === 'temporada' ? 'Catálogo de temporada' : 'Catálogo general 2026',
);

const abrir = (tipo) => {
    catalogo.value = tipo;
    abierto.value = true;
};

const cerrar = () => {
    abierto.value = false;
};

const onKey = (event) => {
    if (event.key === 'Escape') {
        cerrar();
    }
};

onMounted(() => {
    const previo = page.props.catalogModal;
    if (previo === 'general' || previo === 'temporada') {
        catalogo.value = previo;
        abierto.value = true;
    }
    window.addEventListener('keydown', onKey);
});

onUnmounted(() => {
    window.removeEventListener('keydown', onKey);
});
</script>

<template>
    <section
        class="bg-brand-orange bg-cover bg-center bg-no-repeat py-16 text-white sm:py-20"
        aria-labelledby="catalogo-titulo"
    >
        <div class="mx-auto max-w-5xl px-4 text-center sm:px-6 lg:px-8">
            <h2 id="catalogo-titulo" class="mt-2 text-3xl font-extrabold drop-shadow-md sm:text-4xl">
                Descarga el catálogo
            </h2>
            <p class="mt-2 text-sm font-extrabold">
                Chécate nuestros productos, descarga nuestro catálogo y mantente actualizado.
            </p>

            <div class="mt-8 grid grid-cols-1 items-start gap-10 md:grid-cols-2">
                <article>
                    <button
                        type="button"
                        class="mx-auto flex max-w-[320px] rounded-[8px] transition hover:scale-[1.02] focus:outline-hidden focus-visible:ring-2 focus-visible:ring-white"
                        @click="abrir('general')"
                    >
                        <img
                            src="/img/productos/portada-catalogo-2026.webp"
                            alt="Catálogo Globos Sensacional 2026"
                            class="h-auto w-full rounded-[8px] object-contain shadow-lg"
                        />
                    </button>
                    <p class="mt-4 text-base font-extrabold">Catálogo general 2026</p>
                </article>

                <article>
                    <button
                        type="button"
                        class="mx-auto flex max-w-[320px] rounded-[8px] transition hover:scale-[1.02] focus:outline-hidden focus-visible:ring-2 focus-visible:ring-white"
                        @click="abrir('temporada')"
                    >
                        <img
                            src="/img/productos/glossensacional-de-temporada2026.jpg"
                            alt="Catálogo de temporada Globos Sensacional 2026"
                            class="h-auto w-full rounded-[8px] object-contain shadow-lg"
                        />
                    </button>
                    <p class="mt-4 text-base font-extrabold">Catálogo de temporada</p>
                </article>
            </div>

            <p class="mx-auto mt-10 max-w-3xl text-base leading-relaxed sm:text-lg">
                Tenemos más de 30 años de experiencia en la creación de globos 100%
                biodegradables de látex natural, 56 colores divididos en 5 familias,
                más los diseños especiales. ¿Qué esperas para unirte y llevar tu
                negocio a otro nivel?
            </p>
        </div>

        <div
            v-if="abierto"
            class="fixed inset-0 z-[70] flex items-center justify-center px-4"
            role="dialog"
            aria-modal="true"
            aria-labelledby="modal-catalogo-titulo"
        >
            <button
                type="button"
                class="absolute inset-0 bg-gray-900/60"
                aria-label="Cerrar"
                @click="cerrar"
            />

            <div class="relative w-full max-w-md overflow-hidden rounded-2xl bg-white text-left text-gray-900 shadow-2xl">
                <div class="h-1.5 bg-brand-red" />
                <button
                    type="button"
                    class="absolute right-3 top-4 rounded-full p-1 text-gray-400 hover:text-gray-700"
                    aria-label="Cerrar aviso"
                    @click="cerrar"
                >
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"
                        />
                    </svg>
                </button>

                <form class="px-6 pb-6 pt-5 sm:px-8" method="POST" :action="route('catalogo.solicitar')">
                    <input type="hidden" name="_token" :value="csrf" />
                    <input type="hidden" name="catalogo" :value="catalogo" />
                    <p class="text-xs font-bold uppercase tracking-[0.18em] text-brand-orange">
                        Descarga
                    </p>
                    <h3 id="modal-catalogo-titulo" class="mt-2 pr-8 text-2xl font-extrabold leading-tight">
                        {{ titulo }}
                    </h3>
                    <p class="mt-3 text-sm leading-relaxed text-gray-600">
                        Agrega tu correo para enviarte información de nuestros catálogos y promociones.
                    </p>
                    <label for="correo-catalogo" class="mt-5 block text-sm font-medium text-gray-700">
                        Correo electrónico
                    </label>
                    <input
                        id="correo-catalogo"
                        type="email"
                        name="email"
                        required
                        autocomplete="email"
                        placeholder="tucorreo@empresa.com"
                        :value="page.props.oldEmail || ''"
                        class="mt-1 w-full rounded-lg border-gray-300 px-4 py-2.5 text-sm shadow-xs focus:border-brand-cyan focus:ring-brand-cyan"
                    />
                    <p v-if="emailError || seasonalError" class="mt-2 text-sm font-semibold text-brand-red" role="alert">
                        {{ emailError || seasonalError }}
                    </p>
                    <button
                        type="submit"
                        class="mt-4 w-full rounded-lg bg-brand-red px-4 py-3.5 text-sm font-bold uppercase tracking-wide text-white transition hover:bg-brand-orange"
                    >
                        Descargar catálogo
                    </button>
                </form>
            </div>
        </div>
    </section>
</template>
