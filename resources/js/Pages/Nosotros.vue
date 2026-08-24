<script setup>
import AboutStory from '@/Components/Nosotros/AboutStory.vue';
import GreenCommitment from '@/Components/Nosotros/GreenCommitment.vue';
import Locations from '@/Components/Nosotros/Locations.vue';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage();
const appUrl = computed(() => page.props.appUrl ?? page.props.ziggy?.url ?? '');
const description = computed(
    () =>
        'Conoce la historia de Globos Sensacional: más de 30 años de fabricación de globos de látex 100% biodegradables. Oficinas en Puebla y fábrica en Jalisco. Envíos a todo México.',
);
const canonical = computed(() => `${appUrl.value}/nosotros`);
const ogImage = computed(() => `${appUrl.value}/img/productos/fabrica.webp`);
</script>

<template>
    <PublicLayout>
        <Head title="Nosotros">
            <meta name="description" :content="description" />
            <link rel="canonical" :href="canonical" />
            <meta property="og:type" content="website" />
            <meta property="og:locale" content="es_MX" />
            <meta property="og:site_name" content="Globos Sensacionales" />
            <meta property="og:title" content="Nosotros | Globos Sensacionales" />
            <meta property="og:description" :content="description" />
            <meta property="og:url" :href="canonical" />
            <meta property="og:image" :content="ogImage" />
        </Head>

        <div class="pt-40 sm:pt-36">
            <AboutStory />
            <Locations />
            <GreenCommitment />
            <section aria-label="Globos ecológicos">
                <img
                    src="/img/productos/globos-ecologicos.webp"
                    alt="Globos ecológicos Sensacional"
                    class="block h-auto w-full"
                    loading="lazy"
                    decoding="async"
                />
            </section>
        </div>
    </PublicLayout>
</template>
