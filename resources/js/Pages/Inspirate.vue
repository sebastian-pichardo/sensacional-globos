<script setup>
import InspirateCommunity from '@/Components/Inspirate/InspirateCommunity.vue';
import InspirateForm from '@/Components/Inspirate/InspirateForm.vue';
import InspirateHero from '@/Components/Inspirate/InspirateHero.vue';
import InspirateIntro from '@/Components/Inspirate/InspirateIntro.vue';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage();
const appUrl = computed(() => page.props.appUrl ?? page.props.ziggy?.url ?? '');
const description = computed(
    () =>
        'Únete a la comunidad de decoradores Sensacional: dinámicas, premios, eventos, colaboraciones y publicación de los mejores trabajos con créditos. Envíos a todo México.',
);
const canonical = computed(() => `${appUrl.value}/inspirate`);
const ogImage = computed(() => `${appUrl.value}/img/productos/globossensacional-inspirate.png`);
</script>

<template>
    <PublicLayout>
        <Head title="Inspírate">
            <meta name="description" :content="description" />
            <link rel="canonical" :href="canonical" />
            <meta property="og:type" content="website" />
            <meta property="og:locale" content="es_MX" />
            <meta property="og:site_name" content="Globos Sensacionales" />
            <meta property="og:title" content="Inspírate | Globos Sensacionales" />
            <meta property="og:description" :content="description" />
            <meta property="og:url" :href="canonical" />
            <meta property="og:image" :content="ogImage" />
        </Head>

        <div class="pt-40 sm:pt-36">
            <InspirateHero />
            <InspirateIntro />
            <InspirateForm />
            <InspirateCommunity />
        </div>
    </PublicLayout>
</template>
