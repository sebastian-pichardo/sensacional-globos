<script setup>
import InputError from '@/Components/InputError.vue';
import { useForm } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';

const STORAGE_KEY = 'gs_distributor_popup';
const DAYS = 7;
const visible = ref(false);
const submitted = ref(false);

const form = useForm({
    email: '',
});

const wasDismissed = () => {
    try {
        const raw = localStorage.getItem(STORAGE_KEY);
        if (!raw) {
            return false;
        }
        const saved = Number(raw);
        return Date.now() - saved < DAYS * 24 * 60 * 60 * 1000;
    } catch {
        return false;
    }
};

const persist = () => {
    try {
        localStorage.setItem(STORAGE_KEY, String(Date.now()));
    } catch {
        // ignore
    }
};

const close = () => {
    visible.value = false;
    persist();
};

const submit = () => {
    form.post(route('leads.store'), {
        preserveScroll: true,
        onSuccess: () => {
            submitted.value = true;
            persist();
            setTimeout(() => {
                visible.value = false;
            }, 1800);
        },
    });
};

onMounted(() => {
    if (wasDismissed()) {
        return;
    }
    setTimeout(() => {
        visible.value = true;
    }, 900);
});
</script>

<template>
    <div
        v-if="visible"
        class="fixed inset-0 z-50 flex items-center justify-center px-4"
        role="dialog"
        aria-modal="true"
        aria-labelledby="popup-distribuidor-titulo"
    >
        <button
            type="button"
            class="absolute inset-0 bg-gray-900/60"
            aria-label="Cerrar"
            @click="close"
        />

        <div class="relative w-full max-w-md overflow-hidden rounded-2xl bg-white shadow-2xl">
            <div class="h-2 bg-gradient-to-r from-brand-red via-brand-yellow to-brand-cyan" />
            <button
                type="button"
                class="absolute right-3 top-4 rounded-full p-1 text-gray-500 hover:text-brand-red"
                aria-label="Cerrar aviso"
                @click="close"
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

            <div class="px-6 py-8 sm:px-8">
                <p class="text-xs font-bold uppercase tracking-widest text-brand-orange">
                    Distribuidores autorizados
                </p>
                <h2 id="popup-distribuidor-titulo" class="mt-2 text-2xl font-bold text-gray-900">
                    Conviértete en distribuidor autorizado y gana un 10% de descuento
                </h2>
                <p class="mt-3 text-sm text-gray-600">
                    Al registrarte ahora mismo. Suma nuestro catálogo a tu negocio y recibe
                    <strong>envíos a todo México</strong>.
                </p>

                <p v-if="submitted" class="mt-6 rounded-lg bg-brand-green/15 p-3 text-sm font-medium text-gray-900">
                    ¡Listo! Te contactaremos para activar tu descuento de distribuidor.
                </p>

                <form v-else class="mt-6 space-y-3" @submit.prevent="submit">
                    <label for="lead-email" class="block text-sm font-medium text-gray-700">
                        Correo electrónico
                    </label>
                    <input
                        id="lead-email"
                        v-model="form.email"
                        type="email"
                        required
                        autocomplete="email"
                        placeholder="tucorreo@empresa.com"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-brand-cyan focus:ring-brand-cyan"
                    />
                    <InputError :message="form.errors.email" />
                    <button
                        type="submit"
                        class="w-full rounded-lg bg-brand-red px-4 py-3 text-sm font-bold uppercase tracking-wide text-white transition hover:bg-brand-orange disabled:opacity-60"
                        :disabled="form.processing"
                    >
                        Registrarme ahora
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>
