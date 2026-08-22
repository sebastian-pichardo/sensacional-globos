<script setup>
import ContactForm from '@/Components/Home/ContactForm.vue';
import DistributorCatalog from '@/Components/Distribuidores/DistributorCatalog.vue';
import DistributorFamily from '@/Components/Distribuidores/DistributorFamily.vue';
import DistributorHero from '@/Components/Distribuidores/DistributorHero.vue';
import DistributorSearch from '@/Components/Distribuidores/DistributorSearch.vue';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

defineProps({
    estados: {
        type: Array,
        required: true,
    },
    distribuidores: {
        type: Array,
        required: true,
    },
    states: {
        type: Array,
        required: true,
    },
    catalogHint: {
        type: String,
        required: true,
    },
});

const page = usePage();
const appUrl = computed(() => page.props.appUrl ?? page.props.ziggy?.url ?? '');
const description = computed(
    () =>
        'Encuentra a tu distribuidor Sensacional. Somos aliados de los mejores distribuidores del país. Envíos a todo México.',
);
const canonical = computed(() => `${appUrl.value}/encuentra-un-distribuidor`);
const ogImage = computed(() => `${appUrl.value}/img/logo/globos-fiesta.webp`);
</script>

<template>
    <PublicLayout>
        <Head title="Encuentra un distribuidor">
            <meta name="description" :content="description" />
            <link rel="canonical" :href="canonical" />
            <meta property="og:type" content="website" />
            <meta property="og:locale" content="es_MX" />
            <meta property="og:site_name" content="Globos Sensacionales" />
            <meta property="og:title" content="Encuentra un distribuidor | Globos Sensacionales" />
            <meta property="og:description" :content="description" />
            <meta property="og:url" :href="canonical" />
            <meta property="og:image" :content="ogImage" />
        </Head>

        <div class="pt-40 sm:pt-36">
            <DistributorHero />
            <DistributorSearch :estados="estados" :distribuidores="distribuidores" />
            <DistributorFamily />
            <DistributorCatalog :hint="catalogHint" />
            <ContactForm
                :states="states"
                title="¡Queremos saber de tí!"
                description="Escríbenos y con gusto nos pondremos en contacto para vivir juntos un momento sensacional."
            />
        </div>
    </PublicLayout>
</template>
