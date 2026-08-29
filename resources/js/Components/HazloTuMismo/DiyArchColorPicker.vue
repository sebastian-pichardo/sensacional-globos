<script setup>
import { computed, ref, watch } from 'vue';

const props = defineProps({
    lineasColor: {
        type: Object,
        required: true,
    },
});

const groups = computed(() => [
    {
        key: 'estandar',
        label: 'Grupo A',
        lineName: 'Estándar',
        note: null,
        colors: props.lineasColor?.estandar ?? [],
    },
    {
        key: 'metal',
        label: 'Grupo B',
        lineName: 'Metal',
        note: null,
        colors: props.lineasColor?.metal ?? [],
    },
    {
        key: 'moda',
        label: 'Grupo C',
        lineName: 'Fashion',
        note: 'Globos de 43 cm 17"',
        colors: props.lineasColor?.moda ?? [],
    },
]);

const selected = ref({
    estandar: null,
    metal: null,
    moda: null,
});

watch(
    groups,
    (next) => {
        for (const group of next) {
            if (!selected.value[group.key] && group.colors.length > 0) {
                selected.value[group.key] = group.colors[0];
            }
        }
    },
    { immediate: true, deep: true },
);

const colorA = computed(() => selected.value.estandar?.color ?? '#2563eb');
const colorB = computed(() => selected.value.metal?.color ?? '#f1f5f9');
const colorC = computed(() => selected.value.moda?.color ?? '#ffffff');

function selectColor(groupKey, color) {
    selected.value[groupKey] = color;
}

function isSelected(groupKey, color) {
    return selected.value[groupKey]?.id === color.id;
}

function shade(hex, amount) {
    const raw = String(hex || '#888888').replace('#', '');
    const full = raw.length === 3 ? raw.split('').map((c) => c + c).join('') : raw.padEnd(6, '0').slice(0, 6);
    const num = Number.parseInt(full, 16);
    if (Number.isNaN(num)) {
        return hex;
    }

    const clamp = (value) => Math.min(255, Math.max(0, value));
    const r = clamp((num >> 16) + amount);
    const g = clamp(((num >> 8) & 0xff) + amount);
    const b = clamp((num & 0xff) + amount);

    return `#${((r << 16) | (g << 8) | b).toString(16).padStart(6, '0')}`;
}

const gradientA = computed(() => ({
    light: shade(colorA.value, 55),
    mid: colorA.value,
    dark: shade(colorA.value, -45),
}));

const gradientB = computed(() => ({
    light: shade(colorB.value, 55),
    mid: colorB.value,
    dark: shade(colorB.value, -45),
}));

const gradientC = computed(() => ({
    light: shade(colorC.value, 55),
    mid: colorC.value,
    dark: shade(colorC.value, -45),
}));
</script>

<template>
    <div
        class="mt-14 overflow-hidden rounded-3xl bg-white/90 px-4 py-8 sm:px-6 sm:py-10 lg:px-8"
        style="
            background-image: radial-gradient(circle at 12% 18%, rgba(238, 130, 238, 0.12) 0 18px, transparent 19px),
                radial-gradient(circle at 78% 12%, rgba(243, 146, 0, 0.1) 0 14px, transparent 15px),
                radial-gradient(circle at 88% 72%, rgba(149, 27, 129, 0.1) 0 22px, transparent 23px),
                radial-gradient(circle at 18% 78%, rgba(50, 190, 240, 0.1) 0 16px, transparent 17px),
                linear-gradient(180deg, #fff7fb 0%, #ffffff 55%, #fffaf5 100%);
        "
    >
        <div class="grid items-start gap-10 lg:grid-cols-2 lg:gap-12">
            <div class="space-y-8 text-left">
                <div v-for="group in groups" :key="group.key">
                    <h3 class="text-2xl font-extrabold text-gray-900 sm:text-3xl">
                        {{ group.label }}
                    </h3>
                    <p v-if="group.note" class="mt-1 text-sm text-gray-600">
                        {{ group.note }}
                    </p>

                    <div class="mt-3 flex flex-wrap items-end gap-3">
                        <span
                            class="inline-flex rounded-full bg-brand-orange px-4 py-1.5 text-xs font-bold uppercase tracking-wide text-white"
                        >
                            Línea de colores
                        </span>
                        <span
                            class="min-w-[7rem] flex-1 border-b border-dotted border-gray-400 pb-1 text-sm font-semibold text-gray-800"
                        >
                            {{ group.lineName }}
                        </span>
                    </div>

                    <div
                        v-if="group.colors.length"
                        class="mt-4 flex flex-wrap gap-3"
                        role="listbox"
                        :aria-label="`Colores ${group.lineName}`"
                    >
                        <button
                            v-for="swatch in group.colors"
                            :key="`${group.key}-${swatch.id}`"
                            type="button"
                            role="option"
                            :aria-selected="isSelected(group.key, swatch)"
                            :title="swatch.nombre"
                            :aria-label="swatch.nombre"
                            class="group relative h-11 w-11 rounded-full transition hover:scale-105 focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-orange focus-visible:ring-offset-2"
                            :class="
                                isSelected(group.key, swatch)
                                    ? 'ring-[3px] ring-gray-900 ring-offset-2'
                                    : 'ring-1 ring-black/10'
                            "
                            :style="{ backgroundColor: swatch.color }"
                            @click="selectColor(group.key, swatch)"
                        >
                            <span
                                class="pointer-events-none absolute bottom-full left-1/2 z-10 mb-2 -translate-x-1/2 whitespace-nowrap rounded bg-gray-900 px-2 py-1 text-[11px] font-semibold uppercase tracking-wide text-white opacity-0 shadow transition group-hover:opacity-100 group-focus-visible:opacity-100"
                            >
                                {{ swatch.nombre }}
                            </span>
                        </button>
                    </div>
                    <p v-else class="mt-4 text-sm text-gray-500">
                        No hay colores disponibles en esta línea.
                    </p>
                </div>
            </div>

            <div class="mx-auto w-full max-w-lg lg:mx-0 lg:max-w-none" aria-hidden="true">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 1000 1000"
                    class="h-auto w-full"
                    role="img"
                    aria-label="Arco de globos con los colores seleccionados"
                >
                    <defs>
                        <pattern
                            id="arco-grid"
                            width="40"
                            height="40"
                            patternUnits="userSpaceOnUse"
                            patternTransform="rotate(45)"
                        >
                            <path
                                d="M 40 0 L 0 0 0 40"
                                fill="none"
                                stroke="#e2e8f0"
                                stroke-width="1.5"
                            />
                        </pattern>

                        <radialGradient id="arcoGradA" cx="35%" cy="35%" r="65%">
                            <stop offset="0%" :stop-color="gradientA.light" />
                            <stop offset="40%" :stop-color="gradientA.mid" />
                            <stop offset="100%" :stop-color="gradientA.dark" />
                        </radialGradient>
                        <radialGradient id="arcoGradB" cx="35%" cy="35%" r="65%">
                            <stop offset="0%" :stop-color="gradientB.light" />
                            <stop offset="40%" :stop-color="gradientB.mid" />
                            <stop offset="100%" :stop-color="gradientB.dark" />
                        </radialGradient>
                        <radialGradient id="arcoGradC" cx="35%" cy="35%" r="65%">
                            <stop offset="0%" :stop-color="gradientC.light" />
                            <stop offset="50%" :stop-color="gradientC.mid" />
                            <stop offset="100%" :stop-color="gradientC.dark" />
                        </radialGradient>
                    </defs>

                    <rect width="1000" height="1000" fill="#ffffff" />
                    <rect width="1000" height="1000" fill="url(#arco-grid)" />

                    <g stroke="#0f172a" stroke-width="4" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="280" cy="830" r="75" fill="url(#arcoGradC)" />
                        <path
                            d="M 245 795 Q 265 775 295 790"
                            fill="none"
                            stroke="#ffffff"
                            stroke-width="6"
                            opacity="0.8"
                        />

                        <circle cx="260" cy="690" r="85" fill="url(#arcoGradA)" />
                        <path
                            d="M 220 655 Q 245 630 275 645"
                            fill="none"
                            stroke="#ffffff"
                            stroke-width="6"
                            opacity="0.8"
                        />
                        <circle cx="345" cy="680" r="38" fill="url(#arcoGradB)" />

                        <circle cx="270" cy="570" r="60" fill="url(#arcoGradC)" />
                        <circle cx="370" cy="600" r="65" fill="url(#arcoGradB)" />

                        <circle cx="320" cy="480" r="90" fill="url(#arcoGradA)" />
                        <path
                            d="M 280 440 Q 310 410 350 430"
                            fill="none"
                            stroke="#ffffff"
                            stroke-width="6"
                            opacity="0.8"
                        />
                        <circle cx="435" cy="495" r="70" fill="url(#arcoGradA)" />

                        <circle cx="370" cy="370" r="75" fill="url(#arcoGradC)" />

                        <circle cx="330" cy="250" r="80" fill="url(#arcoGradA)" />
                        <circle cx="460" cy="320" r="65" fill="url(#arcoGradB)" />

                        <circle cx="360" cy="140" r="68" fill="url(#arcoGradA)" />
                        <circle cx="475" cy="205" r="72" fill="url(#arcoGradB)" />

                        <circle cx="465" cy="110" r="55" fill="url(#arcoGradA)" />
                        <circle cx="585" cy="115" r="115" fill="url(#arcoGradA)" />
                        <path
                            d="M 520 60 Q 565 20 615 45"
                            fill="none"
                            stroke="#ffffff"
                            stroke-width="8"
                            opacity="0.9"
                        />
                        <path
                            d="M 535 80 Q 550 65 575 75"
                            fill="none"
                            stroke="#ffffff"
                            stroke-width="5"
                            opacity="0.8"
                        />

                        <circle cx="610" cy="210" r="65" fill="url(#arcoGradB)" />
                        <circle cx="740" cy="290" r="80" fill="url(#arcoGradA)" />

                        <circle cx="730" cy="150" r="65" fill="url(#arcoGradC)" />
                        <circle cx="810" cy="210" r="50" fill="url(#arcoGradC)" />
                        <circle cx="780" cy="250" r="45" fill="url(#arcoGradA)" />

                        <circle cx="845" cy="295" r="65" fill="url(#arcoGradB)" />
                        <circle cx="810" cy="415" r="75" fill="url(#arcoGradC)" />

                        <circle cx="915" cy="375" r="55" fill="url(#arcoGradA)" />
                        <circle cx="880" cy="485" r="90" fill="url(#arcoGradA)" />
                        <circle cx="930" cy="580" r="68" fill="url(#arcoGradC)" />

                        <circle cx="865" cy="625" r="65" fill="url(#arcoGradB)" />
                        <circle cx="980" cy="590" r="45" fill="url(#arcoGradC)" />
                        <circle cx="815" cy="700" r="50" fill="url(#arcoGradA)" />
                        <circle cx="935" cy="685" r="85" fill="url(#arcoGradB)" />
                        <path
                            d="M 895 650 Q 925 625 955 640"
                            fill="none"
                            stroke="#ffffff"
                            stroke-width="6"
                            opacity="0.8"
                        />

                        <circle cx="910" cy="830" r="75" fill="url(#arcoGradC)" />
                        <path
                            d="M 875 795 Q 895 775 925 790"
                            fill="none"
                            stroke="#ffffff"
                            stroke-width="6"
                            opacity="0.8"
                        />
                    </g>
                </svg>
            </div>
        </div>
    </div>
</template>
