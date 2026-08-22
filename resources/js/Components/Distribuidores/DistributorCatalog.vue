<script setup>
import { usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

defineProps({
    hint: {
        type: String,
        required: true,
    },
});

const page = usePage();
const clave = ref('');
const catalogError = computed(() => page.props.flash?.catalog_error || '');
const csrf = computed(() => page.props.csrf_token || '');
</script>

<template>
    <section
        class="bg-brand-cyan bg-cover bg-center bg-no-repeat py-16 text-gray-900 sm:py-20"
        style="background-image: url('/img/productos/banner-azul.webp')"
        aria-labelledby="catalogo-distribuidores"
    >
        <div class="mx-auto max-w-3xl px-4 text-center sm:px-6 lg:px-8">
            <p class="text-xs font-bold uppercase tracking-[0.2em] text-gray-900/70">
                Solo para distribuidores
            </p>
            <h2 id="catalogo-distribuidores" class="mt-2 text-3xl font-extrabold sm:text-4xl">
                Descarga nuestro catálogo
            </h2>
            <p class="mt-6 text-base leading-relaxed sm:text-lg">
                Obtén toda la información necesaria para tener un evento sensacional.
            </p>

            <form
                class="mx-auto mt-8 max-w-md rounded-3xl bg-white/90 p-6 text-left shadow-lg ring-1 ring-black/5"
                method="POST"
                :action="route('distribuidores.catalogo')"
            >
                <input type="hidden" name="_token" :value="csrf" />
                <label for="clave-catalogo" class="block text-sm font-medium text-gray-700">
                    Clave de distribuidor
                </label>
                <input
                    id="clave-catalogo"
                    v-model="clave"
                    type="password"
                    name="clave"
                    required
                    autocomplete="off"
                    class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-brand-cyan focus:ring-brand-cyan"
                />
                <button
                    type="submit"
                    class="mt-5 w-full rounded-full bg-brand-red px-8 py-4 text-sm font-bold uppercase tracking-wide text-white shadow-lg transition hover:bg-brand-orange"
                >
                    Descargar catálogo
                </button>
            </form>

            <p
                class="mt-6 text-sm leading-relaxed"
                :class="catalogError ? 'rounded-2xl bg-white/80 px-4 py-3 font-semibold text-brand-red' : 'text-gray-800'"
                role="status"
            >
                {{ catalogError || hint }}
            </p>
        </div>
    </section>
</template>
