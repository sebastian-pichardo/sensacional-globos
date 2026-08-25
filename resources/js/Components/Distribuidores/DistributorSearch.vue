<script setup>
import { computed, ref, watch } from 'vue';

const props = defineProps({
    estados: {
        type: Array,
        required: true,
    },
    distribuidores: {
        type: Array,
        required: true,
    },
});

const PER_PAGE = 3;
const estadoClave = ref('');
const pagina = ref(1);

const estadoSeleccionado = computed(
    () => props.estados.find((estado) => estado.clave_sat === estadoClave.value) ?? null,
);

const resultados = computed(() => {
    if (!estadoClave.value) {
        return [];
    }

    return props.distribuidores.filter(
        (distribuidor) => distribuidor.estado_clave === estadoClave.value,
    );
});

const totalPaginas = computed(() => Math.max(1, Math.ceil(resultados.value.length / PER_PAGE)));

const paginaActual = computed(() => {
    const items = resultados.value;
    const inicio = (pagina.value - 1) * PER_PAGE;

    return items.slice(inicio, inicio + PER_PAGE);
});

watch(estadoClave, () => {
    pagina.value = 1;
});

const mapsUrl = (distribuidor) =>
    `https://www.google.com/maps/search/?api=1&query=${encodeURIComponent(
        `${distribuidor.latitude},${distribuidor.longitude}`,
    )}`;

const whatsappUrl = (numero) => {
    const digits = String(numero).replace(/\D/g, '');
    return `https://wa.me/${digits}`;
};

const irAPagina = (numero) => {
    if (numero < 1 || numero > totalPaginas.value) {
        return;
    }

    pagina.value = numero;
};
</script>

<template>
    <section class="bg-white py-16 sm:py-20" aria-labelledby="buscador-titulo">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            <p class="text-center text-xs font-bold uppercase tracking-[0.2em] text-brand-cyan">
                Buscador
            </p>
            <div class="mt-2 flex items-center justify-center gap-3 sm:gap-4">
                <span
                    class="inline-flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-brand-cyan text-white sm:h-14 sm:w-14"
                    aria-hidden="true"
                >
                    <svg
                        class="h-6 w-6 sm:h-7 sm:w-7"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
                        />
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"
                        />
                    </svg>
                </span>
                <h2 id="buscador-titulo" class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    Elige tu estado
                </h2>
            </div>
            <p class="mx-auto mt-3 max-w-2xl text-center text-gray-600">
                Selecciona un estado para ver a nuestros distribuidores autorizados cerca de ti.
            </p>

            <label for="estado-distribuidor" class="mt-10 block text-sm font-medium text-gray-700">
                Estado
            </label>
            <select
                id="estado-distribuidor"
                v-model="estadoClave"
                class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-brand-cyan focus:ring-brand-cyan"
            >
                <option value="" disabled>Selecciona un estado</option>
                <option
                    v-for="estado in estados"
                    :key="estado.clave_sat"
                    :value="estado.clave_sat"
                >
                    {{ estado.nombre }}
                </option>
            </select>

            <p v-if="!estadoClave" class="mt-8 text-center text-sm text-gray-500">
                Elige un estado para mostrar la lista de distribuidores.
            </p>

            <!-- rounded-3xl border-t-8 bg-gray-50 p-5 shadow-sm -->
            <div v-else-if="resultados.length" class="mt-8" aria-live="polite">
                <ul class="space-y-4">
                    <li
                        v-for="distribuidor in paginaActual"
                        :key="distribuidor.id"
                        class="rounded-3xl bg-gray-50 p-5 shadow-sm ring-1 ring-black/5 sm:p-6"
                    >
                        <div class="flex gap-4 sm:gap-5">
                            <img
                                src="/img/logo/logo-distribuidor.webp"
                                alt="Globos sensacional"
                                class="h-20 w-20 shrink-0 object-contain sm:h-48 sm:w-48"
                            />

                            <div class="min-w-0 flex-1">
                                <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                                    <div class="min-w-0">
                                        <h3 class="text-xl font-extrabold text-gray-900">
                                            {{ distribuidor.empresa || 'Distribuidor Sensacional' }}
                                        </h3>
                                        <p
                                            v-if="distribuidor.estado"
                                            class="mt-1 text-sm font-semibold text-brand-purple"
                                        >
                                            {{ distribuidor.estado }}
                                        </p>
                                        <p
                                            v-if="distribuidor.direccion"
                                            class="mt-2 text-sm leading-relaxed text-gray-600"
                                        >
                                            {{ distribuidor.direccion }}
                                        </p>

                                        <div
                                            v-if="distribuidor.telefono || distribuidor.whatsapp"
                                            class="mt-3 flex flex-wrap items-center gap-3"
                                        >
                                            <a
                                                v-if="distribuidor.telefono"
                                                :href="'tel:' + distribuidor.telefono"
                                                class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-brand-red text-white transition hover:bg-brand-orange"
                                                :aria-label="'Llamar a ' + (distribuidor.empresa || 'distribuidor')"
                                                :title="distribuidor.telefono"
                                            >
                                                <svg
                                                    class="h-5 w-5"
                                                    fill="none"
                                                    viewBox="0 0 24 24"
                                                    stroke="currentColor"
                                                    aria-hidden="true"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"
                                                    />
                                                </svg>
                                            </a>
                                            <a
                                                v-if="distribuidor.whatsapp"
                                                :href="whatsappUrl(distribuidor.whatsapp)"
                                                target="_blank"
                                                rel="noopener noreferrer"
                                                class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-brand-green text-white transition hover:bg-brand-cyan"
                                                :aria-label="'WhatsApp de ' + (distribuidor.empresa || 'distribuidor')"
                                                :title="distribuidor.whatsapp"
                                            >
                                                <svg
                                                    class="h-5 w-5"
                                                    viewBox="0 0 24 24"
                                                    fill="currentColor"
                                                    aria-hidden="true"
                                                >
                                                    <path
                                                        d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.435 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"
                                                    />
                                                </svg>
                                            </a>
                                        </div>
                                    </div>

                                    <a
                                        v-if="distribuidor.latitude && distribuidor.longitude"
                                        :href="mapsUrl(distribuidor)"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="inline-flex shrink-0 items-center justify-center rounded-full bg-brand-cyan px-5 py-2 text-xs font-bold uppercase tracking-wide text-white transition hover:bg-brand-red"
                                    >
                                        Ver en Maps
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>

                <nav
                    v-if="totalPaginas > 1"
                    class="mt-8 flex items-center justify-center gap-2"
                    aria-label="Paginación de distribuidores"
                >
                    <button
                        type="button"
                        class="rounded-full border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700 transition hover:border-brand-cyan hover:text-brand-cyan disabled:cursor-not-allowed disabled:opacity-40"
                        :disabled="pagina <= 1"
                        @click="irAPagina(pagina - 1)"
                    >
                        Anterior
                    </button>

                    <button
                        v-for="numero in totalPaginas"
                        :key="numero"
                        type="button"
                        class="inline-flex h-10 w-10 items-center justify-center rounded-full text-sm font-bold transition"
                        :class="
                            numero === pagina
                                ? 'bg-brand-red text-white'
                                : 'border border-gray-300 text-gray-700 hover:border-brand-cyan hover:text-brand-cyan'
                        "
                        :aria-current="numero === pagina ? 'page' : undefined"
                        @click="irAPagina(numero)"
                    >
                        {{ numero }}
                    </button>

                    <button
                        type="button"
                        class="rounded-full border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700 transition hover:border-brand-cyan hover:text-brand-cyan disabled:cursor-not-allowed disabled:opacity-40"
                        :disabled="pagina >= totalPaginas"
                        @click="irAPagina(pagina + 1)"
                    >
                        Siguiente
                    </button>
                </nav>
            </div>

            <p
                v-else
                class="mt-8 rounded-2xl bg-brand-yellow/20 px-5 py-4 text-center text-sm text-gray-700"
                aria-live="polite"
            >
                Aún no tenemos distribuidores registrados en
                {{ estadoSeleccionado?.nombre || 'este estado' }}.
                Escríbenos y te ayudamos a encontrar el más cercano.
            </p>
        </div>
    </section>
</template>
