<script setup>
import ProductBenefits from '@/Components/Productos/ProductBenefits.vue';
import ProductCatalogCta from '@/Components/Productos/ProductCatalogCta.vue';
import CustomBalloons from '@/Components/Productos/CustomBalloons.vue';
import ProductGallery from '@/Components/Productos/ProductGallery.vue';
import ProductGrid from '@/Components/Productos/ProductGrid.vue';
import ProductHero from '@/Components/Productos/ProductHero.vue';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage();
const appUrl = computed(() => page.props.appUrl ?? page.props.ziggy?.url ?? '');
const description = computed(
    () =>
        'Globos de látex de alta calidad, 100% biodegradables: colores estándar, perla, metálicos, cristal, neón, vintage, impresos y de temporada. Envíos a todo México.',
);
const canonical = computed(() => `${appUrl.value}/productos`);
const ogImage = computed(() => `${appUrl.value}/img/productos/globos-colores.webp`);
</script>

<template>
    <PublicLayout>
        <Head title="Productos">
            <meta name="description" :content="description" />
            <link rel="canonical" :href="canonical" />
            <meta property="og:type" content="website" />
            <meta property="og:locale" content="es_MX" />
            <meta property="og:site_name" content="Globos Sensacionales" />
            <meta property="og:title" content="Productos | Globos Sensacionales" />
            <meta property="og:description" :content="description" />
            <meta property="og:url" :href="canonical" />
            <meta property="og:image" :content="ogImage" />
        </Head>

        <div class="pt-40 sm:pt-44">
            <ProductHero />
            <ProductGrid />
            <CustomBalloons />
            <ProductBenefits />
            <ProductGallery />
            <ProductCatalogCta />
        </div>
    </PublicLayout>
</template>
