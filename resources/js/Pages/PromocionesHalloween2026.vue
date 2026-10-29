<script setup>
import InputError from '@/Components/InputError.vue';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import { computed, onBeforeUnmount, onMounted, ref, watch } from 'vue';

const page = usePage();
const appUrl = computed(() => page.props.appUrl ?? page.props.ziggy?.url ?? '');
const canonical = computed(() => `${appUrl.value}/promociones-halloween-2026`);
const description =
    'Participa en el concurso de Halloween 2026 de Globos Sensacional. Vota por tus decoraciones favoritas para primer, segundo y tercer lugar.';
const ogImage = computed(
    () => `${appUrl.value}/img/productos/portada-promocion-de-halloween.png`,
);

const participantes = [
    {
        value: 'los_villanos',
        title: 'Los Villanos',
        displayLabel: '“Los villanos”',
        image: '/img/productos/concurso-octubre1-globossensacional-2026.webp',
    },
    {
        value: 'hola_frankie',
        title: 'Hola frankie',
        displayLabel: 'Hola frankie',
        image: '/img/productos/concurso-octubre2-globossensacional-2026.webp',
    },
    {
        value: 'arco_halloween',
        title: 'Arco de halloween',
        displayLabel: 'Arco de halloween',
        image: '/img/productos/concurso-octubre3-globossensacional-2026.webp',
    },
    {
        value: 'monstruo_frankie',
        title: 'Monstruo frankie',
        displayLabel: 'Monstruo frankie',
        image: '/img/productos/concurso-octubre4-globossensacional-2026.webp',
    },
];

const form = useForm({
    email: '',
    tercero: '',
    segundo: '',
    primero: '',
    accept_terms: false,
});

const emailTouched = ref(false);
const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;

const isEmailValid = computed(() => emailRegex.test(form.email.trim()));
const showEmailFormatWarning = computed(
    () => emailTouched.value && form.email.trim().length > 0 && !isEmailValid.value,
);

const canSelectTercero = computed(() => isEmailValid.value);
const canSelectSegundo = computed(() => canSelectTercero.value && Boolean(form.tercero));
const canSelectPrimero = computed(() => canSelectSegundo.value && Boolean(form.segundo));
const allPlacesSelected = computed(
    () =>
        canSelectPrimero.value &&
        Boolean(form.tercero) &&
        Boolean(form.segundo) &&
        Boolean(form.primero),
);
const canSubmit = computed(() => allPlacesSelected.value && form.accept_terms);

watch(isEmailValid, (valid) => {
    if (!valid) {
        form.tercero = '';
        form.segundo = '';
        form.primero = '';
        form.accept_terms = false;
    }
});

watch(
    () => form.tercero,
    (newVal) => {
        if (!newVal) {
            form.segundo = '';
            form.primero = '';
            form.accept_terms = false;
            return;
        }
        if (form.segundo === newVal) {
            form.segundo = '';
            form.primero = '';
            form.accept_terms = false;
        }
        if (form.primero === newVal) {
            form.primero = '';
            form.accept_terms = false;
        }
    },
);

watch(
    () => form.segundo,
    (newVal) => {
        if (!newVal) {
            form.primero = '';
            form.accept_terms = false;
            return;
        }
        if (form.primero === newVal) {
            form.primero = '';
            form.accept_terms = false;
        }
    },
);

watch(
    () => form.primero,
    (newVal) => {
        if (!newVal) {
            form.accept_terms = false;
        }
    },
);

const isOptionDisabledForSegundo = (value) => value === form.tercero;
const isOptionDisabledForPrimero = (value) => value === form.tercero || value === form.segundo;

const selectedImageIndex = ref(null);
const selectedParticipant = computed(() =>
    selectedImageIndex.value !== null ? participantes[selectedImageIndex.value] : null,
);

const openImageModal = (index) => {
    selectedImageIndex.value = index;
};

const closeImageModal = () => {
    selectedImageIndex.value = null;
};

const prevImage = () => {
    if (selectedImageIndex.value === null) return;
    selectedImageIndex.value =
        (selectedImageIndex.value - 1 + participantes.length) % participantes.length;
};

const nextImage = () => {
    if (selectedImageIndex.value === null) return;
    selectedImageIndex.value = (selectedImageIndex.value + 1) % participantes.length;
};

const handleKeydown = (event) => {
    if (selectedImageIndex.value === null) return;
    if (event.key === 'Escape') {
        closeImageModal();
    } else if (event.key === 'ArrowLeft') {
        prevImage();
    } else if (event.key === 'ArrowRight') {
        nextImage();
    }
};

onMounted(() => {
    window.addEventListener('keydown', handleKeydown);
});

onBeforeUnmount(() => {
    window.removeEventListener('keydown', handleKeydown);
});

const submit = () => {
    if (!canSubmit.value || form.processing) return;

    form.post(route('promociones-halloween-2026.store'), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            emailTouched.value = false;
        },
    });
};
</script>

<template>
    <PublicLayout>
        <Head title="Promociones Halloween 2026">
            <meta name="description" :content="description" />
            <link rel="canonical" :href="canonical" />
            <meta property="og:type" content="website" />
            <meta property="og:locale" content="es_MX" />
            <meta property="og:site_name" content="Globos Sensacionales" />
            <meta property="og:title" content="Promociones Halloween 2026 | Globos Sensacionales" />
            <meta property="og:description" :content="description" />
            <meta property="og:url" :href="canonical" />
            <meta property="og:image" :content="ogImage" />
        </Head>

        <section
            class="relative min-h-screen overflow-hidden bg-white bg-repeat pt-32 pb-0 sm:pt-36"
            style="background-image: url('/img/productos/fondo-promcion.jpeg'); background-size: 640px auto;"
        >
            <div class="relative z-10 mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
                <!-- Portada centrada y texto animado de Globoween 2 -->
                <div class="mx-auto mb-12 max-w-4xl text-center sm:mb-14">
                    <div class="flex justify-center">
                        <img
                            src="/img/productos/portada-promocion-de-halloween.png"
                            alt="Globoween 2 - ¡Deja volar tu creatividad con globos!"
                            class="globoween-float w-full max-w-xs drop-shadow-[0_12px_20px_rgba(107,26,155,0.25)] sm:max-w-md md:max-w-lg"
                        />
                    </div>

                    <div class="mt-6 space-y-4 px-2 sm:mt-8">
                        <h1
                            class="globoween-fade-up globoween-gradient-text text-2xl font-extrabold tracking-tight sm:text-3xl md:text-4xl"
                        >
                            ¡Ayúdanos a decidir quiénes serán los ganadores de nuestros grandes
                            premios!
                        </h1>

                        <p
                            class="globoween-fade-up globoween-delay-1 mx-auto max-w-3xl text-base font-semibold leading-relaxed text-[#4a126e] sm:text-lg"
                        >
                            Por segundo año consecutivo regresa
                            <span class="font-extrabold text-[#e6692e]">Globoween</span>
                            para probar las habilidades y el arte de nuestros colaboradores.
                        </p>

                        <p
                            class="globoween-fade-up globoween-delay-2 mx-auto max-w-3xl text-base font-medium leading-relaxed text-gray-800 sm:text-lg"
                        >
                            Ellos hicieron decoraciones increíbles y es tu turno de decidir el
                            <span class="font-extrabold text-[#6b1a9b]"
                                >primero, segundo y tercer lugar</span
                            >; en tus manos está la corona de esta dinámica.
                        </p>

                        <p
                            class="globoween-fade-up globoween-delay-3 mx-auto max-w-3xl text-base font-bold leading-relaxed text-[#e6692e] sm:text-lg"
                        >
                            ¡Llena el formulario y haz que la mejor decoración con
                            <span class="text-[#6b1a9b]">Globos Sensacional</span> gane. Las
                            creaciones con más votos serán los reyes de este
                            <span
                                class="inline-block rounded-lg bg-[#6b1a9b] px-2.5 py-0.5 text-white shadow-xs"
                                >Globoween 2</span
                            >!
                        </p>

                        <div
                            class="globoween-fade-up globoween-delay-4 mt-6 flex flex-col items-center justify-center gap-3 pt-2 sm:flex-row sm:flex-wrap sm:gap-4"
                        >
                            <div
                                class="globoween-pulse-badge inline-flex items-center gap-2 rounded-full border-2 border-[#6b1a9b] bg-[#6b1a9b]/10 px-5 py-2 text-sm font-bold text-[#6b1a9b] shadow-xs sm:text-base"
                            >
                                <span aria-hidden="true">🎃</span>
                                <span>
                                    Duración de la dinámica:
                                    <strong class="text-[#e6692e]"
                                        >30 de Octubre - 03 de Noviembre</strong
                                    >
                                </span>
                            </div>

                            <div
                                class="globoween-pulse-badge inline-flex items-center gap-2 rounded-full border-2 border-[#e6692e] bg-[#e6692e]/10 px-5 py-2 text-sm font-bold text-[#4a126e] shadow-xs sm:text-base"
                            >
                                <span aria-hidden="true">👑</span>
                                <span>
                                    Anuncio del ganador:
                                    <strong class="text-[#e6692e]"
                                        >En nuestro live el 04 de Noviembre por facebook a las
                                        19:00 hrs.</strong
                                    >
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Galería de los 4 participantes -->
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4 lg:gap-7">
                    <div
                        v-for="(item, index) in participantes"
                        :key="item.value"
                        class="flex flex-col items-center"
                    >
                        <button
                            type="button"
                            class="group relative w-full overflow-hidden border-[6px] border-[#6b1a9b] bg-white shadow-md transition-transform duration-300 hover:scale-[1.03] hover:shadow-xl focus:outline-none focus:ring-4 focus:ring-[#6b1a9b]/40 cursor-zoom-in"
                            :aria-label="`Ver imagen más grande de ${item.title}`"
                            @click="openImageModal(index)"
                        >
                            <div class="aspect-square w-full overflow-hidden bg-white">
                                <img
                                    :src="item.image"
                                    :alt="item.title"
                                    class="h-full w-full object-contain transition-transform duration-300 group-hover:scale-105"
                                />
                            </div>
                            <span
                                class="pointer-events-none absolute right-2 bottom-2 inline-flex items-center gap-1 rounded-full bg-[#6b1a9b]/85 px-2.5 py-1 text-xs font-semibold text-white opacity-0 shadow transition-opacity duration-200 group-hover:opacity-100"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-3.5 w-3.5"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="2"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M21 21l-4.35-4.35m1.85-5.15a7 7 0 11-14 0 7 7 0 0114 0zM10.5 7.5v6m-3-3h6"
                                    />
                                </svg>
                                Ampliar
                            </span>
                        </button>

                        <h2 class="mt-3 text-center text-lg font-medium text-gray-900 sm:text-xl">
                            {{ item.displayLabel }}
                        </h2>
                    </div>
                </div>

                <!-- Mensaje de estado / instrucciones breves -->
                <div
                    v-if="$page.props.flash?.success"
                    class="mx-auto mt-8 max-w-2xl rounded-2xl border-2 border-green-500 bg-green-50 px-6 py-4 text-center text-sm font-semibold text-green-800 shadow-sm sm:text-base"
                >
                    {{ $page.props.flash.success }}
                </div>

                <!-- Formulario de votación, superpuesto a la escena inferior -->
                <form
                    class="halloween-form relative z-20 mx-auto max-w-3xl space-y-5"
                    novalidate
                    @submit.prevent="submit"
                >
                    <!-- Primer lugar (se habilita al final, tras elegir segundo lugar) -->
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:gap-6">
                        <label
                            for="select-primero"
                            class="flex h-12 w-full shrink-0 items-center justify-center rounded-full bg-[#6b1a9b] px-6 text-center text-base font-bold text-white shadow-sm sm:w-52 sm:text-lg"
                        >
                            Primer lugar
                        </label>
                        <div class="w-full flex-1">
                            <select
                                id="select-primero"
                                v-model="form.primero"
                                :disabled="!canSelectPrimero"
                                class="h-12 w-full rounded-full border-[4px] border-[#6b1a9b] bg-white px-5 text-sm font-medium text-gray-800 shadow-xs transition focus:border-[#6b1a9b] focus:ring-2 focus:ring-[#6b1a9b]/30 disabled:cursor-not-allowed disabled:bg-gray-100/90 disabled:text-gray-400 disabled:opacity-70 sm:text-base"
                            >
                                <option value="" disabled>
                                    {{
                                        canSelectPrimero
                                            ? 'Selecciona el primer lugar...'
                                            : 'Se habilita después de elegir el segundo lugar'
                                    }}
                                </option>
                                <option
                                    v-for="item in participantes"
                                    :key="`primero-${item.value}`"
                                    :value="item.value"
                                    :disabled="isOptionDisabledForPrimero(item.value)"
                                >
                                    {{ item.title }}
                                    {{
                                        isOptionDisabledForPrimero(item.value)
                                            ? ' (Ya seleccionado)'
                                            : ''
                                    }}
                                </option>
                            </select>
                            <InputError class="mt-1 pl-4" :message="form.errors.primero" />
                        </div>
                    </div>

                    <!-- Segundo lugar (se habilita tras elegir tercer lugar) -->
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:gap-6">
                        <label
                            for="select-segundo"
                            class="flex h-12 w-full shrink-0 items-center justify-center rounded-full bg-[#e6692e] px-6 text-center text-base font-bold text-white shadow-sm sm:w-52 sm:text-lg"
                        >
                            Segundo lugar
                        </label>
                        <div class="w-full flex-1">
                            <select
                                id="select-segundo"
                                v-model="form.segundo"
                                :disabled="!canSelectSegundo"
                                class="h-12 w-full rounded-full border-[4px] border-[#e6692e] bg-white px-5 text-sm font-medium text-gray-800 shadow-xs transition focus:border-[#e6692e] focus:ring-2 focus:ring-[#e6692e]/30 disabled:cursor-not-allowed disabled:bg-gray-100/90 disabled:text-gray-400 disabled:opacity-70 sm:text-base"
                            >
                                <option value="" disabled>
                                    {{
                                        canSelectSegundo
                                            ? 'Selecciona el segundo lugar...'
                                            : 'Se habilita después de elegir el tercer lugar'
                                    }}
                                </option>
                                <option
                                    v-for="item in participantes"
                                    :key="`segundo-${item.value}`"
                                    :value="item.value"
                                    :disabled="isOptionDisabledForSegundo(item.value)"
                                >
                                    {{ item.title }}
                                    {{
                                        isOptionDisabledForSegundo(item.value)
                                            ? ' (Ya seleccionado)'
                                            : ''
                                    }}
                                </option>
                            </select>
                            <InputError class="mt-1 pl-4" :message="form.errors.segundo" />
                        </div>
                    </div>

                    <!-- Tercer lugar (se habilita primero al ingresar un correo válido) -->
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:gap-6">
                        <label
                            for="select-tercero"
                            class="flex h-12 w-full shrink-0 items-center justify-center rounded-full bg-[#6b1a9b] px-6 text-center text-base font-bold text-white shadow-sm sm:w-52 sm:text-lg"
                        >
                            Tercer lugar
                        </label>
                        <div class="w-full flex-1">
                            <select
                                id="select-tercero"
                                v-model="form.tercero"
                                :disabled="!canSelectTercero"
                                class="h-12 w-full rounded-full border-[4px] border-[#6b1a9b] bg-white px-5 text-sm font-medium text-gray-800 shadow-xs transition focus:border-[#6b1a9b] focus:ring-2 focus:ring-[#6b1a9b]/30 disabled:cursor-not-allowed disabled:bg-gray-100/90 disabled:text-gray-400 disabled:opacity-70 sm:text-base"
                            >
                                <option value="" disabled>
                                    {{
                                        canSelectTercero
                                            ? 'Selecciona el tercer lugar...'
                                            : 'Primero ingresa un correo electrónico válido abajo'
                                    }}
                                </option>
                                <option
                                    v-for="item in participantes"
                                    :key="`tercero-${item.value}`"
                                    :value="item.value"
                                >
                                    {{ item.title }}
                                </option>
                            </select>
                            <InputError class="mt-1 pl-4" :message="form.errors.tercero" />
                        </div>
                    </div>

                    <!-- Correo electrónico (paso 1 para habilitar la votación) -->
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:gap-6">
                        <label
                            for="input-email"
                            class="flex h-12 w-full shrink-0 items-center justify-center rounded-full bg-[#e6692e] px-6 text-center text-base font-bold text-white shadow-sm sm:w-52 sm:text-lg"
                        >
                            Correo
                        </label>
                        <div class="w-full flex-1">
                            <input
                                id="input-email"
                                v-model="form.email"
                                type="email"
                                required
                                autocomplete="email"
                                placeholder="Ingresa tu correo electrónico válido para votar..."
                                class="h-12 w-full rounded-full border-[4px] border-[#e6692e] bg-white px-5 text-sm font-medium text-gray-800 shadow-xs transition focus:border-[#e6692e] focus:ring-2 focus:ring-[#e6692e]/30 sm:text-base"
                                @blur="emailTouched = true"
                                @input="
                                    if (form.errors.email) {
                                        form.clearErrors('email');
                                    }
                                "
                            />
                            <p
                                v-if="showEmailFormatWarning"
                                class="mt-1 pl-4 text-xs font-medium text-amber-700 sm:text-sm"
                            >
                                Ingresa un correo electrónico con formato válido (ejemplo:
                                correo@dominio.com) para habilitar el tercer lugar.
                            </p>
                            <InputError class="mt-1 pl-4" :message="form.errors.email" />
                        </div>
                    </div>

                    <!-- Checkbox de términos y condiciones (se habilita al elegir los 3 lugares) -->
                    <div class="flex flex-col gap-3 pt-2 sm:flex-row sm:items-center sm:gap-6">
                        <div class="hidden sm:block sm:w-52 sm:shrink-0"></div>
                        <div class="w-full flex-1">
                            <label
                                for="accept-terms"
                                class="inline-flex items-center gap-3 rounded-2xl bg-white px-3 py-2 shadow-sm transition"
                                :class="
                                    allPlacesSelected
                                        ? 'cursor-pointer text-gray-800'
                                        : 'cursor-not-allowed text-gray-400 opacity-65'
                                "
                            >
                                <input
                                    id="accept-terms"
                                    v-model="form.accept_terms"
                                    type="checkbox"
                                    :disabled="!allPlacesSelected"
                                    class="h-5 w-5 rounded border-2 border-[#6b1a9b] text-[#6b1a9b] transition focus:ring-[#6b1a9b] disabled:cursor-not-allowed disabled:border-gray-300"
                                />
                                <span class="text-sm font-medium sm:text-base">
                                    Aceptas términos y condiciones de esta promoción
                                    <Link
                                        :href="route('aviso-de-privacidad')"
                                        class="ml-1 underline decoration-[#6b1a9b]/50 underline-offset-2 hover:text-[#6b1a9b]"
                                        @click.stop
                                    >
                                        (ver aviso de privacidad)
                                    </Link>
                                </span>
                            </label>
                            <InputError class="mt-1 pl-3" :message="form.errors.accept_terms" />
                        </div>
                    </div>

                    <!-- Botón Enviar con suave efecto fade de aparecer -->
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:gap-6">
                        <div class="hidden sm:block sm:w-52 sm:shrink-0"></div>
                        <div class="w-full flex-1">
                            <Transition
                                enter-active-class="transition-all duration-700 ease-out"
                                enter-from-class="opacity-0 translate-y-2"
                                enter-to-class="opacity-100 translate-y-0"
                                leave-active-class="transition-all duration-300 ease-in"
                                leave-from-class="opacity-100 translate-y-0"
                                leave-to-class="opacity-0 translate-y-2"
                            >
                                <button
                                    v-if="canSubmit"
                                    type="submit"
                                    :disabled="form.processing"
                                    class=" flex h-12 w-full items-center justify-center rounded-full bg-[#e6692e] px-10 text-base font-bold text-white shadow-md transition hover:bg-[#d45a20] focus:outline-none focus:ring-4 focus:ring-[#e6692e]/40 disabled:opacity-60 sm:w-56 sm:text-lg cursor-pointer"
                                >
                                    {{ form.processing ? 'Enviando...' : 'Enviar' }}
                                </button>
                            </Transition>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Escena a todo el ancho: sube detrás del formulario y queda sobre el pie de página -->
            <div class="halloween-scene pointer-events-none relative z-0 w-full select-none" aria-hidden="true">
                <img
                    src="/img/productos/fondo-halloween.png"
                    alt=""
                    class="block h-auto w-full max-w-none"
                />
            </div>
        </section>

        <!-- Lightbox Modal para ampliar la imagen al hacer click -->
        <Transition
            enter-active-class="transition duration-200 ease-out"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="transition duration-150 ease-in"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div
                v-if="selectedParticipant"
                class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 p-4 backdrop-blur-xs"
                role="dialog"
                aria-modal="true"
                :aria-label="selectedParticipant.title"
                @click.self="closeImageModal"
            >
                <div
                    class="relative flex max-h-[92vh] w-full max-w-3xl flex-col items-center overflow-hidden rounded-2xl border-4 border-[#6b1a9b] bg-white p-4 shadow-2xl sm:p-6"
                >
                    <button
                        type="button"
                        class="absolute top-3 right-3 z-10 inline-flex h-10 w-10 items-center justify-center rounded-full bg-[#6b1a9b] text-white shadow-md transition hover:bg-[#521278] focus:outline-none focus:ring-2 focus:ring-[#6b1a9b]"
                        aria-label="Cerrar vista ampliada"
                        @click="closeImageModal"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-6 w-6"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2.5"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M6 18L18 6M6 6l12 12"
                            />
                        </svg>
                    </button>

                    <!-- Controles anterior / siguiente -->
                    <button
                        type="button"
                        class="absolute top-1/2 left-3 z-10 -translate-y-1/2 inline-flex h-10 w-10 items-center justify-center rounded-full bg-[#6b1a9b]/90 text-white shadow-md transition hover:bg-[#521278]"
                        aria-label="Imagen anterior"
                        @click.stop="prevImage"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2.5"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M15 19l-7-7 7-7"
                            />
                        </svg>
                    </button>

                    <button
                        type="button"
                        class="absolute top-1/2 right-3 z-10 -translate-y-1/2 inline-flex h-10 w-10 items-center justify-center rounded-full bg-[#6b1a9b]/90 text-white shadow-md transition hover:bg-[#521278]"
                        aria-label="Imagen siguiente"
                        @click.stop="nextImage"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2.5"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M9 5l7 7-7 7"
                            />
                        </svg>
                    </button>

                    <img
                        :src="selectedParticipant.image"
                        :alt="selectedParticipant.title"
                        class="max-h-[75vh] w-auto object-contain"
                    />

                    <h3 class="mt-3 text-center text-xl font-bold text-[#6b1a9b] sm:text-2xl">
                        {{ selectedParticipant.displayLabel }}
                    </h3>
                </div>
            </div>
        </Transition>
    </PublicLayout>
</template>

<style scoped>
@keyframes globoweenFloat {
    0%,
    100% {
        transform: translateY(0px) scale(1);
    }
    50% {
        transform: translateY(-8px) scale(1.02);
    }
}

@keyframes globoweenShimmer {
    0% {
        background-position: 0% 50%;
    }
    50% {
        background-position: 100% 50%;
    }
    100% {
        background-position: 0% 50%;
    }
}

@keyframes globoweenFadeUp {
    from {
        opacity: 0;
        transform: translateY(16px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes globoweenPulseBadge {
    0%,
    100% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.025);
    }
}

.globoween-float {
    animation: globoweenFloat 4s ease-in-out infinite;
}

.globoween-gradient-text {
    background: linear-gradient(90deg, #6b1a9b 0%, #e6692e 50%, #6b1a9b 100%);
    background-size: 200% auto;
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
    animation:
        globoweenFadeUp 0.7s ease-out both,
        globoweenShimmer 5s linear infinite;
}

.globoween-fade-up {
    animation: globoweenFadeUp 0.75s ease-out both;
}

.globoween-delay-1 {
    animation-delay: 0.15s;
}

.globoween-delay-2 {
    animation-delay: 0.3s;
}

.globoween-delay-3 {
    animation-delay: 0.45s;
}

.globoween-delay-4 {
    animation-delay: 0.6s;
}

.globoween-pulse-badge {
    animation: globoweenPulseBadge 3s ease-in-out infinite;
}

.halloween-form {
    margin-top: 2.5rem;
}

.halloween-scene {
    margin-top: -3.5rem;
}

@media (min-width: 640px) {
    .halloween-form {
        margin-top: 3rem;
    }

    .halloween-scene {
        margin-top: -10rem;
    }
}

@media (min-width: 1024px) {
    .halloween-form {
        margin-top: clamp(3rem, calc(26vw - 20rem), 18rem);
    }

    .halloween-scene {
        margin-top: clamp(-40rem, -26vw, -16rem);
    }
}
</style>

