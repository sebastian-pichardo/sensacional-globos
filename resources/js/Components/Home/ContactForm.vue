<script setup>
import InputError from '@/Components/InputError.vue';
import { useForm } from '@inertiajs/vue3';

defineProps({
    states: {
        type: Array,
        required: true,
    },
    title: {
        type: String,
        default: '¡Queremos saber de ti!',
    },
    description: {
        type: String,
        default:
            'Escríbenos y con gusto nos pondremos en contacto para vivir juntos una fiesta sensacional. Ideal si buscas mayoreo, distribución o conocer nuestra fábrica. Envíos a todo México.',
    },
});

const form = useForm({
    name: '',
    email: '',
    phone: '',
    company: '',
    state: '',
    message: '',
});

const submit = () => {
    form.post(route('contacto.store'), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
    });
};
</script>

<template>
    <section class="bg-white py-16 sm:py-20" aria-labelledby="contacto-titulo">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            <h2 id="contacto-titulo" class="text-center text-3xl font-extrabold text-gray-900 sm:text-4xl">
                {{ title }}
            </h2>
            <p class="mt-4 text-center text-gray-600">
                {{ description }}
            </p>

            <form class="mt-10 grid gap-5" @submit.prevent="submit">
                <div>
                    <label for="contact-name" class="block text-sm font-medium text-gray-700">Nombre</label>
                    <input
                        id="contact-name"
                        v-model="form.name"
                        type="text"
                        required
                        autocomplete="name"
                        class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-brand-cyan focus:ring-brand-cyan"
                    />
                    <InputError class="mt-1" :message="form.errors.name" />
                </div>

                <div>
                    <label for="contact-email" class="block text-sm font-medium text-gray-700">
                        Correo electrónico
                    </label>
                    <input
                        id="contact-email"
                        v-model="form.email"
                        type="email"
                        required
                        autocomplete="email"
                        class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-brand-cyan focus:ring-brand-cyan"
                    />
                    <InputError class="mt-1" :message="form.errors.email" />
                </div>

                <div>
                    <label for="contact-phone" class="block text-sm font-medium text-gray-700">
                        Número de teléfono
                    </label>
                    <input
                        id="contact-phone"
                        v-model="form.phone"
                        type="tel"
                        required
                        autocomplete="tel"
                        class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-brand-cyan focus:ring-brand-cyan"
                    />
                    <InputError class="mt-1" :message="form.errors.phone" />
                </div>

                <div>
                    <label for="contact-company" class="block text-sm font-medium text-gray-700">
                        Nombre de empresa
                    </label>
                    <input
                        id="contact-company"
                        v-model="form.company"
                        type="text"
                        autocomplete="organization"
                        class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-brand-cyan focus:ring-brand-cyan"
                    />
                    <InputError class="mt-1" :message="form.errors.company" />
                </div>

                <div>
                    <label for="contact-state" class="block text-sm font-medium text-gray-700">
                        Dónde nos escribes
                    </label>
                    <select
                        id="contact-state"
                        v-model="form.state"
                        required
                        class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-brand-cyan focus:ring-brand-cyan"
                    >
                        <option value="" disabled>Selecciona un estado</option>
                        <option v-for="state in states" :key="state" :value="state">
                            {{ state }}
                        </option>
                    </select>
                    <InputError class="mt-1" :message="form.errors.state" />
                </div>

                <div>
                    <label for="contact-message" class="block text-sm font-medium text-gray-700">
                        Mensaje
                    </label>
                    <textarea
                        id="contact-message"
                        v-model="form.message"
                        required
                        rows="5"
                        class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-brand-cyan focus:ring-brand-cyan"
                    />
                    <InputError class="mt-1" :message="form.errors.message" />
                </div>

                <button
                    type="submit"
                    class="rounded-lg bg-brand-red px-6 py-3 text-sm font-bold uppercase tracking-wide text-white transition hover:bg-brand-orange disabled:opacity-60"
                    :disabled="form.processing"
                >
                    Enviar mensaje
                </button>
            </form>
        </div>
    </section>
</template>
