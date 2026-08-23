<script setup>
import DiyCreativityCta from '@/Components/HazloTuMismo/DiyCreativityCta.vue';
import DiyDiagramCta from '@/Components/HazloTuMismo/DiyDiagramCta.vue';
import DiyHero from '@/Components/HazloTuMismo/DiyHero.vue';
import DiyTechniques from '@/Components/HazloTuMismo/DiyTechniques.vue';
import DiyTutorials from '@/Components/HazloTuMismo/DiyTutorials.vue';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage();
const appUrl = computed(() => page.props.appUrl ?? page.props.ziggy?.url ?? '');
const description = computed(
    () =>
        'Aprende técnicas con globos Sensacional: guirnaldas, backdrops, torres, mosaicos, esculturas y más. Tutoriales en video e instructivo descargable para crear decoraciones sensacionales.',
);
const canonical = computed(() => `${appUrl.value}/hazlo-tu-mismo`);
const ogImage = computed(() => `${appUrl.value}/img/globos/guirnalda-1.webp`);
</script>

<template>
    <PublicLayout>
        <Head title="Hazlo tú mismo">
            <meta name="description" :content="description" />
            <link rel="canonical" :href="canonical" />
            <meta property="og:type" content="website" />
            <meta property="og:locale" content="es_MX" />
            <meta property="og:site_name" content="Globos Sensacionales" />
            <meta property="og:title" content="Hazlo tú mismo | Globos Sensacionales" />
            <meta property="og:description" :content="description" />
            <meta property="og:url" :href="canonical" />
            <meta property="og:image" :content="ogImage" />
        </Head>

        <div class="pt-40 sm:pt-36">
            <DiyHero />
            <DiyTechniques />
            <DiyCreativityCta />
            <DiyTutorials />
            <DiyDiagramCta />
        </div>
    </PublicLayout>
</template>
