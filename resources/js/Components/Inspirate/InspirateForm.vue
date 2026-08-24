<script setup>
import InputError from '@/Components/InputError.vue';
import { Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    whatsapp: '',
    email: '',
    motivation: '',
    social_networks: '',
    city_or_state: '',
    accept_promotions: false,
});

const submit = () => {
    form.post(route('inspirate.store'), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
    });
};
</script>

<template>
    <section
        id="inscripcion"
        class="scroll-mt-36 bg-gray-50 py-16 sm:py-20"
        aria-labelledby="inscripcion-titulo"
    >
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            <h2 id="inscripcion-titulo" class="text-center text-3xl font-extrabold text-gray-900 sm:text-4xl">
                Es tu oportunidad: inscríbete aquí
            </h2>
            <p class="mt-4 text-center text-gray-600">
                Completa el formulario y forma parte de la comunidad de decoradores Sensacional.
            </p>

            <form class="mt-10 grid gap-5" @submit.prevent="submit">
                <div>
                    <label for="inspirate-name" class="block text-sm font-medium text-gray-700">
                        Nombre
                    </label>
                    <input
                        id="inspirate-name"
                        v-model="form.name"
                        type="text"
                        required
                        autocomplete="name"
                        class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-brand-cyan focus:ring-brand-cyan"
                    />
                    <InputError class="mt-1" :message="form.errors.name" />
                </div>

                <div>
                    <label for="inspirate-whatsapp" class="block text-sm font-medium text-gray-700">
                        WhatsApp
                    </label>
                    <input
                        id="inspirate-whatsapp"
                        v-model="form.whatsapp"
                        type="tel"
                        required
                        autocomplete="tel"
                        class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-brand-cyan focus:ring-brand-cyan"
                    />
                    <InputError class="mt-1" :message="form.errors.whatsapp" />
                </div>

                <div>
                    <label for="inspirate-email" class="block text-sm font-medium text-gray-700">
                        Correo electrónico
                    </label>
                    <input
                        id="inspirate-email"
                        v-model="form.email"
                        type="email"
                        required
                        autocomplete="email"
                        class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-brand-cyan focus:ring-brand-cyan"
                    />
                    <InputError class="mt-1" :message="form.errors.email" />
                </div>

                <div>
                    <label for="inspirate-motivation" class="block text-sm font-medium text-gray-700">
                        ¿Por qué te gustaría ser decorador sensacional?
                    </label>
                    <textarea
                        id="inspirate-motivation"
                        v-model="form.motivation"
                        required
                        rows="4"
                        class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-brand-cyan focus:ring-brand-cyan"
                    />
                    <InputError class="mt-1" :message="form.errors.motivation" />
                </div>

                <div>
                    <label for="inspirate-social" class="block text-sm font-medium text-gray-700">
                        Redes sociales
                        <span class="font-normal text-gray-500">(si tienes)</span>
                    </label>
                    <input
                        id="inspirate-social"
                        v-model="form.social_networks"
                        type="text"
                        placeholder="Instagram, Facebook, TikTok…"
                        class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-brand-cyan focus:ring-brand-cyan"
                    />
                    <InputError class="mt-1" :message="form.errors.social_networks" />
                </div>

                <div>
                    <label for="inspirate-city" class="block text-sm font-medium text-gray-700">
                        Ciudad o estado
                    </label>
                    <input
                        id="inspirate-city"
                        v-model="form.city_or_state"
                        type="text"
                        required
                        autocomplete="address-level1"
                        class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-brand-cyan focus:ring-brand-cyan"
                    />
                    <InputError class="mt-1" :message="form.errors.city_or_state" />
                </div>

                <div class="flex items-start gap-3 rounded-lg bg-white p-4 ring-1 ring-gray-200">
                    <input
                        id="inspirate-promotions"
                        v-model="form.accept_promotions"
                        type="checkbox"
                        class="mt-1 rounded border-gray-300 text-brand-red shadow-sm focus:ring-brand-cyan"
                    />
                    <label for="inspirate-promotions" class="text-sm leading-relaxed text-gray-700">
                        Acepto recibir información promocional, dinámicas y ofertas en mis medios de
                        contacto.
                    </label>
                </div>
                <InputError class="mt-1" :message="form.errors.accept_promotions" />

                <button
                    type="submit"
                    class="rounded-lg bg-brand-purple px-6 py-3 text-sm font-bold uppercase tracking-wide text-white transition hover:bg-brand-red disabled:opacity-60"
                    :disabled="form.processing"
                >
                    Enviar inscripción
                </button>
            </form>

            <ul class="mt-10 space-y-3 text-sm leading-relaxed text-gray-600">
                <li>
                    * Inscribirse no garantiza ser acreedor a regalos o envíos por parte de la marca.
                </li>
                <li>
                    * Cualquier dinámica será anunciada por la marca a través de los medios oficiales
                    de contacto designados.
                </li>
                <li>
                    * Nos reservamos el derecho de cambios sin previo aviso.
                    <Link
                        :href="route('aviso-de-privacidad')"
                        class="font-semibold text-brand-purple underline decoration-brand-purple/40 underline-offset-2 hover:text-brand-red"
                    >
                        Consulta el aviso de privacidad aquí
                    </Link>
                </li>
            </ul>
        </div>
    </section>
</template>
