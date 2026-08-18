<script setup>
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    title: { type: String, required: true },
});

const page = usePage();
const shipping = computed(() => page.props.brand?.shipping ?? 'Envíos a todo México');
const description = computed(
    () =>
        `${props.title} | Globos Sensacionales. Fabricación de globos de látex para distribuidores. Envíos a todo México.`,
);
</script>

<template>
    <PublicLayout>
        <Head :title="props.title">
            <meta name="description" :content="description" />
            <meta property="og:title" :content="props.title + ' | Globos Sensacionales'" />
            <meta property="og:description" :content="description" />
        </Head>

        <section class="flex min-h-[70vh] items-center bg-gradient-to-b from-brand-cyan/20 to-white px-4 pt-32 pb-16">
            <div class="mx-auto max-w-2xl text-center">
                <p class="text-xs font-bold uppercase tracking-[0.2em] text-brand-red">
                    {{ shipping }}
                </p>
                <h1 class="mt-3 text-4xl font-extrabold text-gray-900">{{ props.title }}</h1>
                <p class="mt-4 text-gray-600">
                    Esta sección estará disponible pronto. Mientras tanto, conoce nuestros productos
                    en la página de inicio o escríbenos para mayoreo y distribución.
                </p>
                <Link
                    :href="route('home')"
                    class="mt-8 inline-flex rounded-full bg-brand-red px-6 py-3 text-sm font-bold uppercase tracking-wide text-white hover:bg-brand-orange"
                >
                    Volver al inicio
                </Link>
            </div>
        </section>
    </PublicLayout>
</template>
