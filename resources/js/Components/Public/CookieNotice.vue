<script setup>
import { cookieNoticeOpen } from '@/composables/cookieNotice';
import { Link } from '@inertiajs/vue3';
import { nextTick, onBeforeUnmount, onMounted, ref } from 'vue';

const STORAGE_KEY = 'gs_cookie_notice';
const visible = ref(false);
const panel = ref(null);
let resizeObserver;

const syncOffset = () => {
    if (!visible.value || !panel.value) {
        cookieNoticeOpen.value = false;
        document.documentElement.style.setProperty('--cookie-notice-offset', '0px');
        return;
    }
    document.documentElement.style.setProperty(
        '--cookie-notice-offset',
        `${panel.value.offsetHeight + 16}px`,
    );
    cookieNoticeOpen.value = true;
};

const accept = () => {
    resizeObserver?.disconnect();
    visible.value = false;
    cookieNoticeOpen.value = false;
    document.documentElement.style.setProperty('--cookie-notice-offset', '0px');
    try {
        localStorage.setItem(STORAGE_KEY, '1');
    } catch {
        // ignore
    }
};

onMounted(async () => {
    try {
        if (localStorage.getItem(STORAGE_KEY) === '1') {
            return;
        }
    } catch {
        // mostrar el aviso si el almacenamiento no está disponible
    }
    visible.value = true;
    cookieNoticeOpen.value = true;
    await nextTick();
    syncOffset();
    if (typeof ResizeObserver !== 'undefined' && panel.value) {
        resizeObserver = new ResizeObserver(syncOffset);
        resizeObserver.observe(panel.value);
    }
});

onBeforeUnmount(() => {
    resizeObserver?.disconnect();
    cookieNoticeOpen.value = false;
    document.documentElement.style.removeProperty('--cookie-notice-offset');
});
</script>

<template>
    <div
        v-if="visible"
        class="fixed inset-x-3 bottom-3 z-[60] sm:inset-x-auto sm:bottom-5 sm:left-5 sm:w-[22rem]"
        role="dialog"
        aria-modal="false"
        aria-labelledby="aviso-cookies-titulo"
    >
        <div ref="panel" class="max-h-[42vh] overflow-y-auto rounded-2xl bg-white shadow-2xl ring-1 ring-black/10">
            <div class="h-1.5 bg-brand-red" />
            <div class="px-4 py-3 sm:px-4">
                <h2 id="aviso-cookies-titulo" class="text-sm font-extrabold text-gray-900">
                    Aviso sobre el uso de datos personales y cookies
                </h2>
                <div class="mt-2 space-y-2 text-xs leading-relaxed text-gray-600">
                    <p>
                        En nuestro sitio web recopilamos información como tu correo electrónico y
                        utilizamos cookies de sesión para mejorar tu experiencia de navegación,
                        garantizar el correcto funcionamiento de nuestros servicios y brindarte una
                        atención personalizada.
                    </p>
                    <p>
                        Nos comprometemos a proteger tu información y tratarla de manera segura y
                        confidencial.
                    </p>
                    <p>
                        Para conocer más sobre cómo recopilamos, utilizamos y protegemos tus datos
                        personales, te invitamos a consultar nuestro
                        <Link
                            :href="route('aviso-de-privacidad')"
                            class="font-bold text-brand-red underline-offset-2 hover:underline"
                        >
                            Aviso de Privacidad
                        </Link>.
                    </p>
                </div>
                <button
                    type="button"
                    class="mt-4 w-full rounded-lg bg-brand-red px-4 py-2.5 text-sm font-bold uppercase tracking-wide text-white transition hover:bg-brand-orange"
                    @click="accept"
                >
                    Aceptar
                </button>
            </div>
        </div>
    </div>
</template>
