<script setup>
import { usePage } from '@inertiajs/vue3';
import axios from 'axios';
import { computed, onBeforeUnmount, onMounted, ref } from 'vue';

/**
 * @typedef {Object} ColorGlobo
 * @property {number} id
 * @property {string} nombre
 * @property {string} hexadecimal
 */

/**
 * @typedef {Object} GloboCapa
 * @property {number} id
 * @property {string} nombre
 * @property {string} medida
 * @property {string|null} descripcion
 * @property {number} capa
 * @property {string} imagen
 * @property {string|null} imagen_url
 * @property {ColorGlobo[]} colores
 */

/**
 * @typedef {Object} SeleccionGlobo
 * @property {number} globo_id
 * @property {number} color_id
 * @property {string} hexadecimal
 */

const ENDPOINT_CONFIGURACION = '/api/diy-globos/configuracion';
const ENDPOINT_GUARDAR = '/api/diy-globos/guardar-seleccion';
const FONDO_RESPALDO = '/img/productos/arco-globossensacional.webp';

const page = usePage();

/** @type {import('vue').Ref<GloboCapa[]>} */
const globos = ref([]);
/** @type {import('vue').Ref<Record<number, ColorGlobo | null>>} */
const elegido = ref({});
const fondoUrl = ref(FONDO_RESPALDO);
const activoId = ref(null);
const cargando = ref(true);
const errorCarga = ref('');
const guardando = ref(false);
const mensajeGuardado = ref('');
const errorGuardado = ref('');

/** @type {AbortController | null} */
let cargaActual = null;

const globoActivo = computed(() =>
    globos.value.find((globo) => globo.id === activoId.value) ?? null,
);

const coloresActivos = computed(() => globoActivo.value?.colores ?? []);

const seleccion = computed(() =>
    globos.value.flatMap((globo) => {
        const color = elegido.value[globo.id];
        if (!color) {
            return [];
        }

        return [{
            globo_id: globo.id,
            color_id: color.id,
            hexadecimal: color.hexadecimal,
        }];
    }),
);

const puedeGuardar = computed(() =>
    !cargando.value && !guardando.value && seleccion.value.length > 0 && errorCarga.value === '',
);

onMounted(() => {
    cargar();
});

onBeforeUnmount(() => {
    cargaActual?.abort();
});

async function cargar() {
    cargaActual?.abort();
    const controlador = new AbortController();
    cargaActual = controlador;
    cargando.value = true;
    errorCarga.value = '';

    try {
        const { data } = await axios.get(ENDPOINT_CONFIGURACION, {
            signal: controlador.signal,
            headers: { Accept: 'application/json' },
        });
        if (controlador.signal.aborted) {
            return;
        }

        fondoUrl.value = typeof data?.fondo_url === 'string' && data.fondo_url !== ''
            ? data.fondo_url
            : FONDO_RESPALDO;
        const lista = Array.isArray(data?.globos) ? data.globos : [];
        globos.value = lista;
        prepararSeleccion(lista);
    } catch (error) {
        if (axios.isCancel?.(error) || error?.code === 'ERR_CANCELED' || error?.name === 'CanceledError') {
            return;
        }
        errorCarga.value = 'No pudimos cargar la configuración del arco.';
        globos.value = [];
    } finally {
        if (cargaActual === controlador) {
            cargando.value = false;
        }
    }
}

/**
 * @param {GloboCapa[]} lista
 */
function prepararSeleccion(lista) {
    /** @type {Record<number, ColorGlobo | null>} */
    const siguiente = {};
    for (const globo of lista) {
        const previo = elegido.value[globo.id];
        const sigueDisponible = globo.colores?.some((color) => color.id === previo?.id) ?? false;
        siguiente[globo.id] = sigueDisponible ? previo : (globo.colores?.[0] ?? null);
    }
    elegido.value = siguiente;
    if (!lista.some((globo) => globo.id === activoId.value)) {
        activoId.value = lista[0]?.id ?? null;
    }
}

/**
 * @param {GloboCapa} globo
 */
function activarGlobo(globo) {
    activoId.value = globo.id;
    mensajeGuardado.value = '';
}

/**
 * @param {ColorGlobo} color
 */
function elegirColor(color) {
    if (!globoActivo.value) {
        return;
    }

    elegido.value = {
        ...elegido.value,
        [globoActivo.value.id]: color,
    };
    mensajeGuardado.value = '';
    errorGuardado.value = '';
}

/**
 * @param {GloboCapa} globo
 * @returns {ColorGlobo | null}
 */
function colorDe(globo) {
    return elegido.value[globo.id] ?? null;
}

/**
 * @param {string} imagenUrl
 * @param {string} hexadecimal
 */
function estiloTinte(imagenUrl, hexadecimal) {
    const mascara = `url("${imagenUrl}")`;

    return {
        backgroundColor: hexadecimal,
        maskImage: mascara,
        WebkitMaskImage: mascara,
        maskSize: '100% 100%',
        WebkitMaskSize: '100% 100%',
        maskRepeat: 'no-repeat',
        WebkitMaskRepeat: 'no-repeat',
        maskPosition: 'center',
        WebkitMaskPosition: 'center',
    };
}

/**
 * @param {GloboCapa} globo
 */
function esGloboActivo(globo) {
    return globo.id === activoId.value;
}

/**
 * @param {ColorGlobo} color
 */
function esColorActivo(color) {
    const activo = globoActivo.value;
    if (!activo) {
        return false;
    }

    return colorDe(activo)?.id === color.id;
}

function tokenCsrf() {
    const token = page.props.csrf_token;
    return typeof token === 'string' ? token : '';
}

/**
 * @param {unknown} error
 */
function mensajeDeError(error) {
    const respuesta = error?.response;
    if (respuesta?.status === 419) {
        return 'La sesión expiró. Recarga la página e inténtalo de nuevo.';
    }

    const errores = respuesta?.data?.errors;
    if (errores && typeof errores === 'object') {
        const primero = Object.values(errores).flat()[0];
        if (typeof primero === 'string' && primero !== '') {
            return primero;
        }
    }

    const mensaje = respuesta?.data?.message;
    if (typeof mensaje === 'string' && mensaje !== '' && mensaje !== 'The given data was invalid.') {
        return mensaje;
    }

    return 'No se pudo guardar la combinación. Inténtalo de nuevo.';
}

async function guardar() {
    if (!puedeGuardar.value) {
        return;
    }

    guardando.value = true;
    mensajeGuardado.value = '';
    errorGuardado.value = '';

    try {
        const { data } = await axios.post(ENDPOINT_GUARDAR, {
            seleccion: seleccion.value,
        }, {
            headers: {
                Accept: 'application/json',
                'X-CSRF-TOKEN': tokenCsrf(),
            },
        });
        mensajeGuardado.value = typeof data?.message === 'string'
            ? data.message
            : 'Combinación guardada.';
    } catch (error) {
        errorGuardado.value = mensajeDeError(error);
    } finally {
        guardando.value = false;
    }
}
</script>

<template>
    <section class="bg-white py-16 sm:py-20" aria-labelledby="shaker-globos-titulo">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-3xl text-center">
                <p class="text-xs font-bold uppercase tracking-[0.2em] text-brand-orange">
                    Cuatro capas
                </p>
                <h2 id="shaker-globos-titulo" class="mt-2 text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    Personaliza tu arco
                </h2>
                <p class="mt-5 text-base leading-relaxed text-gray-700 sm:text-lg">
                    Elige una medida y tiñe esa capa al instante. Los brillos y las sombras de cada globo se mantienen.
                </p>
            </div>

            <div class="mt-12 grid items-start gap-10 lg:grid-cols-2 lg:gap-12">
                <div class="mx-auto w-full max-w-xl lg:mx-0 lg:max-w-none">
                    <div
                        class="relative aspect-[1312/1167] overflow-hidden rounded-3xl bg-[#f0f0f0] shadow-md ring-1 ring-black/5"
                    >
                        <img
                            :src="fondoUrl"
                            alt="Arco de globos Sensacional listo para personalizar"
                            class="absolute inset-0 h-full w-full"
                            draggable="false"
                        />

                        <div
                            v-for="globo in globos"
                            :key="globo.id"
                            class="pointer-events-none absolute inset-0 isolate"
                        >
                            <template v-if="globo.imagen_url && colorDe(globo)">
                                <img
                                    :src="globo.imagen_url"
                                    alt=""
                                    class="absolute inset-0 h-full w-full"
                                    draggable="false"
                                />
                                <div
                                    class="absolute inset-0 opacity-90 mix-blend-multiply"
                                    :style="estiloTinte(globo.imagen_url, colorDe(globo).hexadecimal)"
                                />
                                <img
                                    :src="globo.imagen_url"
                                    alt=""
                                    class="absolute inset-0 h-full w-full opacity-40 mix-blend-soft-light"
                                    style="filter: contrast(1.15)"
                                    draggable="false"
                                />
                                <img
                                    :src="globo.imagen_url"
                                    alt=""
                                    class="absolute inset-0 h-full w-full opacity-20 mix-blend-screen"
                                    draggable="false"
                                />
                            </template>
                        </div>

                        <div
                            v-if="cargando"
                            class="absolute inset-0 flex items-center justify-center bg-white/70 text-sm font-semibold text-gray-700"
                        >
                            Cargando los globos del arco…
                        </div>
                    </div>
                </div>

                <div class="space-y-5 text-left">
                    <p v-if="errorCarga" class="rounded-2xl bg-red-50 px-4 py-3 text-sm text-red-700 ring-1 ring-red-100" role="alert">
                        {{ errorCarga }}
                        <button
                            type="button"
                            class="ml-2 font-bold underline decoration-red-300 underline-offset-2"
                            @click="cargar"
                        >
                            Reintentar
                        </button>
                    </p>

                    <p v-else class="text-sm text-gray-600">
                        Selecciona una medida y después un color disponible para esa capa.
                    </p>

                    <div
                        v-if="globos.length"
                        class="grid grid-cols-2 gap-2 sm:grid-cols-4"
                        role="group"
                        aria-label="Medidas del arco"
                    >
                        <button
                            v-for="globo in globos"
                            :key="globo.id"
                            type="button"
                            class="rounded-2xl border px-3 py-3 text-left transition focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-orange"
                            :class="esGloboActivo(globo)
                                ? 'border-brand-orange bg-orange-50 shadow-sm'
                                : 'border-gray-200 bg-white hover:border-brand-orange/50'"
                            :aria-pressed="esGloboActivo(globo)"
                            @click="activarGlobo(globo)"
                        >
                            <span
                                class="mb-2 block h-8 w-8 rounded-full ring-1 ring-black/10"
                                :style="{ backgroundColor: colorDe(globo)?.hexadecimal || '#ffffff' }"
                                aria-hidden="true"
                            />
                            <span class="block text-sm font-extrabold text-gray-900">
                                {{ globo.medida }}
                            </span>
                            <span class="mt-0.5 block truncate text-xs text-gray-600">
                                {{ colorDe(globo)?.nombre || 'Sin color' }}
                            </span>
                        </button>
                    </div>
                    <p v-else-if="!cargando && !errorCarga" class="text-sm text-gray-500">
                        Todavía no hay globos disponibles para personalizar.
                    </p>

                    <div v-if="globoActivo" class="rounded-2xl bg-gray-50 p-4 ring-1 ring-black/5">
                        <p class="text-sm font-bold text-gray-900">
                            Colores para {{ globoActivo.medida }}
                        </p>
                        <p class="mt-1 text-xs text-gray-500">
                            {{ globoActivo.nombre }}
                        </p>
                        <div
                            v-if="coloresActivos.length"
                            class="mt-4 grid grid-cols-6 gap-3 sm:grid-cols-8"
                            role="listbox"
                            :aria-label="`Colores de ${globoActivo.medida}`"
                        >
                            <button
                                v-for="color in coloresActivos"
                                :key="color.id"
                                type="button"
                                role="option"
                                :aria-selected="esColorActivo(color)"
                                :title="color.nombre"
                                :aria-label="color.nombre"
                                class="group relative h-11 w-11 justify-self-center rounded-full transition hover:scale-105 focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-orange focus-visible:ring-offset-2"
                                :class="esColorActivo(color)
                                    ? 'ring-[3px] ring-gray-900 ring-offset-2'
                                    : 'ring-1 ring-black/10'"
                                :style="{ backgroundColor: color.hexadecimal }"
                                @click="elegirColor(color)"
                            >
                                <span
                                    class="pointer-events-none absolute bottom-full left-1/2 z-10 mb-2 -translate-x-1/2 whitespace-nowrap rounded bg-gray-900 px-2 py-1 text-[11px] font-semibold text-white opacity-0 shadow transition group-hover:opacity-100 group-focus-visible:opacity-100"
                                >
                                    {{ color.nombre }}
                                </span>
                            </button>
                        </div>
                        <p v-else class="mt-3 text-sm text-gray-500">
                            Esta medida no tiene colores relacionados.
                        </p>
                    </div>

                    <div v-if="seleccion.length" class="rounded-2xl border border-gray-200 bg-white p-4">
                        <p class="text-sm font-bold text-gray-900">
                            Tu combinación
                        </p>
                        <ul class="mt-3 space-y-2">
                            <li
                                v-for="globo in globos"
                                :key="`resumen-${globo.id}`"
                                class="flex items-center gap-3 text-sm text-gray-700"
                            >
                                <span
                                    class="h-5 w-5 shrink-0 rounded-full ring-1 ring-black/10"
                                    :style="{ backgroundColor: colorDe(globo)?.hexadecimal || '#ffffff' }"
                                    aria-hidden="true"
                                />
                                <span class="font-semibold text-gray-900">{{ globo.medida }}</span>
                                <span>{{ colorDe(globo)?.nombre || 'Sin color' }}</span>
                            </li>
                        </ul>

                        <button
                            type="button"
                            class="mt-4 inline-flex items-center justify-center rounded-full bg-brand-orange px-6 py-3 text-sm font-bold text-white transition hover:brightness-95 focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-orange focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                            :disabled="!puedeGuardar"
                            @click="guardar"
                        >
                            {{ guardando ? 'Guardando…' : 'Guardar combinación' }}
                        </button>

                        <p v-if="mensajeGuardado" class="mt-3 text-sm font-semibold text-green-700" role="status">
                            {{ mensajeGuardado }}
                        </p>
                        <p v-if="errorGuardado" class="mt-3 text-sm font-semibold text-red-700" role="alert">
                            {{ errorGuardado }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
