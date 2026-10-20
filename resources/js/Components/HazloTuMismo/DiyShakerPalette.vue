<script setup>
import { computed, onMounted, ref, watch } from 'vue';

const props = defineProps({
    tiposGlobo: {
        type: Array,
        default: () => [],
    },
});

const fotoSrc = '/img/productos/arco-globossensacional.webp';
const mascaraSrc = '/img/productos/arco-globos-mascara.png';

const mascaraPorMedida = {
    '18 cm': 1,
    '23 cm': 2,
    '30 cm': 3,
    '43 cm': 4,
};

const colorOriginal = {
    '18 cm': { nombre: 'Blanco', hexadecimal: '#F4F1EE' },
    '23 cm': { nombre: 'Rosa', hexadecimal: '#F3A4C4' },
    '30 cm': { nombre: 'Salmón', hexadecimal: '#F0B7A8' },
    '43 cm': { nombre: 'Oro', hexadecimal: '#C4A15A' },
};

const lienzo = ref(null);
const preparado = ref(false);
const activoId = ref(props.tiposGlobo[0]?.id ?? null);
const elegido = ref({});

let imagenOriginal = null;
let etiquetas = null;
let ancho = 0;
let alto = 0;

const tipoActivo = computed(() =>
    props.tiposGlobo.find((tipo) => tipo.id === activoId.value) ?? null,
);

const coloresActivos = computed(() => tipoActivo.value?.colores ?? []);

watch(
    () => props.tiposGlobo,
    (tipos) => {
        if (!tipos.some((tipo) => tipo.id === activoId.value)) {
            activoId.value = tipos[0]?.id ?? null;
        }
    },
);

function colorActual(tipo) {
    return elegido.value[tipo.id] ?? colorOriginal[tipo.medida] ?? null;
}

function esMedidaActiva(tipo) {
    return tipo.id === activoId.value;
}

function esColorActivo(color) {
    return elegido.value[activoId.value]?.id === color.id;
}

function activarTipo(tipo) {
    activoId.value = tipo.id;
}

function elegirColor(color) {
    if (!tipoActivo.value) {
        return;
    }

    elegido.value = {
        ...elegido.value,
        [tipoActivo.value.id]: color,
    };
    pintar();
}

function hexARgb(hex) {
    const limpio = String(hex || '').replace('#', '');
    const valor = Number.parseInt(limpio, 16);
    if (Number.isNaN(valor) || limpio.length !== 6) {
        return [200, 200, 200];
    }

    return [(valor >> 16) & 255, (valor >> 8) & 255, valor & 255];
}

function colorizar(rojo, verde, azul, destino) {
    const luz = (0.2126 * rojo + 0.7152 * verde + 0.0722 * azul) / 255;
    const tono = (canal) => {
        const base = canal / 255;
        let mezcla = luz < 0.5 ? 2 * luz * base : 1 - 2 * (1 - luz) * (1 - base);
        if (luz > 0.84) {
            const brillo = (luz - 0.84) / 0.16;
            mezcla = mezcla * (1 - brillo * 0.82) + brillo * 0.82;
        }

        return Math.max(0, Math.min(255, Math.round(mezcla * 255)));
    };

    return [tono(destino[0]), tono(destino[1]), tono(destino[2])];
}

function pintar() {
    const canvas = lienzo.value;
    if (!canvas || !imagenOriginal || !etiquetas) {
        return;
    }

    const contexto = canvas.getContext('2d');
    const frame = new ImageData(new Uint8ClampedArray(imagenOriginal.data), ancho, alto);
    const pixeles = frame.data;
    const destinos = new Map();

    for (const tipo of props.tiposGlobo) {
        const color = elegido.value[tipo.id];
        const etiqueta = mascaraPorMedida[tipo.medida];
        if (!color || !etiqueta) {
            continue;
        }
        destinos.set(etiqueta, hexARgb(color.hexadecimal));
    }

    if (destinos.size > 0) {
        for (let i = 0, p = 0; i < etiquetas.length; i++, p += 4) {
            const destino = destinos.get(etiquetas[i]);
            if (!destino) {
                continue;
            }
            const [rojo, verde, azul] = colorizar(pixeles[p], pixeles[p + 1], pixeles[p + 2], destino);
            pixeles[p] = rojo;
            pixeles[p + 1] = verde;
            pixeles[p + 2] = azul;
        }
    }

    contexto.putImageData(frame, 0, 0);
}

function etiquetaEn(x, y) {
    if (!etiquetas) {
        return 0;
    }

    let mejor = 0;
    let mejorDistancia = 81;
    for (let dy = -8; dy <= 8; dy += 2) {
        for (let dx = -8; dx <= 8; dx += 2) {
            const nx = x + dx;
            const ny = y + dy;
            if (nx < 0 || ny < 0 || nx >= ancho || ny >= alto) {
                continue;
            }
            const etiqueta = etiquetas[ny * ancho + nx];
            if (!etiqueta) {
                continue;
            }
            const distancia = dx * dx + dy * dy;
            if (distancia < mejorDistancia) {
                mejorDistancia = distancia;
                mejor = etiqueta;
            }
        }
    }

    return mejor;
}

function alClic(evento) {
    const canvas = lienzo.value;
    if (!canvas || !preparado.value) {
        return;
    }

    const rect = canvas.getBoundingClientRect();
    const x = Math.floor(((evento.clientX - rect.left) * canvas.width) / rect.width);
    const y = Math.floor(((evento.clientY - rect.top) * canvas.height) / rect.height);
    const etiqueta = etiquetaEn(x, y);
    const tipo = props.tiposGlobo.find((item) => mascaraPorMedida[item.medida] === etiqueta);
    if (tipo) {
        activoId.value = tipo.id;
    }
}

function cargarImagen(src) {
    return new Promise((resolve, reject) => {
        const imagen = new Image();
        imagen.onload = () => resolve(imagen);
        imagen.onerror = () => reject(new Error(src));
        imagen.src = src;
    });
}

onMounted(async () => {
    try {
        const [foto, mascara] = await Promise.all([cargarImagen(fotoSrc), cargarImagen(mascaraSrc)]);
        const canvas = lienzo.value;
        if (!canvas) {
            return;
        }

        ancho = foto.naturalWidth;
        alto = foto.naturalHeight;
        canvas.width = ancho;
        canvas.height = alto;

        const contexto = canvas.getContext('2d', { willReadFrequently: true });
        contexto.drawImage(foto, 0, 0, ancho, alto);
        imagenOriginal = contexto.getImageData(0, 0, ancho, alto);

        const apoyo = document.createElement('canvas');
        apoyo.width = ancho;
        apoyo.height = alto;
        const contextoMascara = apoyo.getContext('2d', { willReadFrequently: true });
        contextoMascara.drawImage(mascara, 0, 0, ancho, alto);
        const datosMascara = contextoMascara.getImageData(0, 0, ancho, alto).data;
        etiquetas = new Uint8Array(ancho * alto);
        for (let i = 0, p = 0; i < etiquetas.length; i++, p += 4) {
            const valor = datosMascara[p];
            etiquetas[i] = valor >= 1 && valor <= 4 ? valor : 0;
        }

        preparado.value = true;
        pintar();
    } catch {
        preparado.value = false;
    }
});
</script>

<template>
    <section class="bg-white py-16 sm:py-20" aria-labelledby="shaker-titulo">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-3xl text-center">
                <p class="text-xs font-bold uppercase tracking-[0.2em] text-brand-orange">
                    Arma tu combinación
                </p>
                <h2 id="shaker-titulo" class="mt-2 text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    Shaker Balloon: Paletas combinadas por ti
                </h2>
                <p class="mt-5 text-base leading-relaxed text-gray-700 sm:text-lg">
                    El arco parte de globos de 18 cm (7") en blanco, 23 cm (9") en rosa, 30 cm (12")
                    en salmón y 43 cm (17") en oro. Elige una medida y cambia su color.
                </p>
            </div>

            <div class="mt-12 grid items-start gap-10 lg:grid-cols-2 lg:gap-12">
                <div class="overflow-hidden rounded-3xl bg-gray-50 shadow-md ring-1 ring-black/5">
                    <img
                        v-show="!preparado"
                        :src="fotoSrc"
                        alt="Arco de globos Sensacional en blanco, rosa, salmón y oro"
                        class="h-auto w-full"
                    />
                    <canvas
                        v-show="preparado"
                        ref="lienzo"
                        class="h-auto w-full cursor-pointer"
                        role="img"
                        aria-label="Arco de globos. Haz clic en un tamaño para elegir su color."
                        @click="alClic"
                    />
                </div>

                <div class="space-y-4 text-left">
                    <p class="text-sm text-gray-600">
                        Selecciona un tipo de globo en la imagen o en la lista. Después elige el color
                        disponible para esa medida.
                    </p>

                    <div v-if="tiposGlobo.length" class="space-y-3">
                        <button
                            v-for="tipo in tiposGlobo"
                            :key="tipo.id"
                            type="button"
                            class="flex w-full items-center gap-4 rounded-2xl border px-4 py-3 text-left transition focus:outline-hidden focus-visible:ring-2 focus-visible:ring-brand-orange"
                            :class="
                                esMedidaActiva(tipo)
                                    ? 'border-brand-orange bg-orange-50 shadow-xs'
                                    : 'border-gray-200 bg-white hover:border-brand-orange/50'
                            "
                            :aria-pressed="esMedidaActiva(tipo)"
                            @click="activarTipo(tipo)"
                        >
                            <span
                                class="h-11 w-11 shrink-0 rounded-full ring-1 ring-black/10"
                                :style="{ backgroundColor: colorActual(tipo)?.hexadecimal || '#ffffff' }"
                                aria-hidden="true"
                            />
                            <span class="min-w-0">
                                <span class="block text-base font-extrabold text-gray-900">
                                    {{ tipo.nombre }}
                                </span>
                                <span class="mt-0.5 block text-sm text-gray-600">
                                    Color: {{ colorActual(tipo)?.nombre || 'Original' }}
                                </span>
                            </span>
                        </button>
                    </div>
                    <p v-else class="text-sm text-gray-500">
                        Todavía no hay medidas de globos disponibles.
                    </p>

                    <div v-if="tipoActivo" class="rounded-2xl bg-gray-50 p-4 ring-1 ring-black/5">
                        <p class="text-sm font-bold text-gray-900">
                            Colores para {{ tipoActivo.nombre }}
                        </p>
                        <div
                            v-if="coloresActivos.length"
                            class="mt-4 flex flex-wrap gap-3"
                            role="listbox"
                            :aria-label="`Colores de ${tipoActivo.nombre}`"
                        >
                            <button
                                v-for="color in coloresActivos"
                                :key="color.id"
                                type="button"
                                role="option"
                                :aria-selected="esColorActivo(color)"
                                :title="color.nombre"
                                :aria-label="color.nombre"
                                class="group relative h-11 w-11 rounded-full transition hover:scale-105 focus:outline-hidden focus-visible:ring-2 focus-visible:ring-brand-orange focus-visible:ring-offset-2"
                                :class="
                                    esColorActivo(color)
                                        ? 'ring-[3px] ring-gray-900 ring-offset-2'
                                        : 'ring-1 ring-black/10'
                                "
                                :style="{ backgroundColor: color.hexadecimal }"
                                @click="elegirColor(color)"
                            >
                                <span
                                    class="pointer-events-none absolute bottom-full left-1/2 z-10 mb-2 -translate-x-1/2 whitespace-nowrap rounded-sm bg-gray-900 px-2 py-1 text-[11px] font-semibold text-white opacity-0 shadow-sm transition group-hover:opacity-100 group-focus-visible:opacity-100"
                                >
                                    {{ color.nombre }}
                                </span>
                            </button>
                        </div>
                        <p v-else class="mt-3 text-sm text-gray-500">
                            Esta medida no tiene colores relacionados.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
