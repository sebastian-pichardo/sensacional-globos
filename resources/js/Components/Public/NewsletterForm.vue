<script setup>
import InputError from '@/Components/InputError.vue';
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('newsletter.store'), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
    });
};
</script>

<template>
    <div>
        <p class="text-sm font-bold uppercase tracking-wide text-brand-cyan">Newsletter</p>
        <p class="mt-3 text-sm text-gray-300">
            Recibe novedades y lanzamientos. Envíos a todo México.
        </p>

        <p
            v-if="form.recentlySuccessful"
            class="mt-4 rounded-lg bg-brand-green/20 px-3 py-2 text-sm font-medium text-white"
            role="status"
        >
            ¡Gracias por registrarte!
        </p>

        <form v-else class="mt-4 space-y-3" @submit.prevent="submit" :aria-busy="form.processing">
            <label for="newsletter-email" class="sr-only">Correo electrónico</label>
            <input
                id="newsletter-email"
                v-model="form.email"
                type="email"
                required
                autocomplete="email"
                placeholder="Tu correo electrónico"
                :disabled="form.processing"
                class="w-full rounded-lg border-white/20 bg-white/10 text-white placeholder:text-gray-400 focus:border-brand-cyan focus:ring-brand-cyan disabled:opacity-60"
            />
            <InputError class="mt-1 text-red-400" :message="form.errors.email" />
            <button
                type="submit"
                class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-brand-red px-4 py-2.5 text-sm font-bold uppercase tracking-wide text-white transition hover:bg-brand-orange disabled:opacity-60"
                :disabled="form.processing"
            >
                <svg
                    v-if="form.processing"
                    class="h-4 w-4 animate-spin"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    aria-hidden="true"
                >
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                    <path
                        class="opacity-75"
                        fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                    />
                </svg>
                {{ form.processing ? 'Enviando...' : 'Registrarme' }}
            </button>
        </form>
    </div>
</template>
