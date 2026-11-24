<script setup>
import CatalogCta from "@/Components/Home/CatalogCta.vue";
import Certifications from "@/Components/Home/Certifications.vue";
import ContactForm from "@/Components/Home/ContactForm.vue";
import HeroSlider from "@/Components/Home/HeroSlider.vue";
import PartyTypes from "@/Components/Home/PartyTypes.vue";
import ProductLines from "@/Components/Home/ProductLines.vue";
import PublicLayout from "@/Layouts/PublicLayout.vue";
import { Head, usePage } from "@inertiajs/vue3";
import { computed } from "vue";

const props = defineProps({
    slides: { type: Array, required: true },
    states: { type: Array, required: true },
});

const page = usePage();
const brand = computed(() => page.props.brand ?? {});
const appUrl = computed(() => page.props.appUrl ?? page.props.ziggy?.url ?? "");
const description = computed(
    () =>
        brand.value.seoDescription ||
        "Globos Sensacional es una de fabrica de globos 100% de látex biodegradables para distribuidores. Envíos a todo México.",
);
const logoUrl = computed(
    () => `${appUrl.value}/img/logo/logo-globos-sensacional.png`,
);
const ogImage = computed(
    () => `${appUrl.value}/img/logo/logo-globos-sensacional.png`,
);
const canonical = computed(() => `${appUrl.value}/`);

const slideKey = computed(() =>
    (props.slides ?? [])
        .map((slide) => `${slide.image}|${slide.imageMobile ?? ""}`)
        .join("|"),
);
const jsonLd = computed(() =>
    JSON.stringify({
        "@context": "https://schema.org",
        "@type": "Organization",
        name: "Globos Sensacional",
        url: appUrl.value,
        logo: logoUrl.value,
        description: description.value,
        areaServed: {
            "@type": "Country",
            name: "Mexico",
        },
        slogan: brand.value.shipping,
    }),
);
</script>

<template>
    <PublicLayout overlay-nav>
        <Head title="Inicio">
            <meta name="description" :content="description" />
            <link rel="canonical" :href="canonical" />
            <meta property="og:type" content="website" />
            <meta property="og:locale" content="es_MX" />
            <meta property="og:site_name" content="Globos Sensacional" />
            <meta
                property="og:title"
                content="Globos Sensacional | Globos de látex 100% biodegradables"
            />
            <meta property="og:description" :content="description" />
            <meta property="og:url" :href="canonical" />
            <meta property="og:image" :content="ogImage" />
            <meta name="twitter:card" content="summary_large_image" />
            <meta
                name="twitter:title"
                content="Globos Sensacional | Fabricación y mayoreo"
            />
            <meta name="twitter:description" :content="description" />
            <meta name="twitter:image" :content="ogImage" />
        </Head>

        <component :is="'script'" type="application/ld+json">{{
            jsonLd
        }}</component>

        <HeroSlider :key="slideKey" :slides="props.slides" />
        <CatalogCta />
        <ProductLines />
        <PartyTypes />
        <Certifications />
        <ContactForm :states="props.states" />
    </PublicLayout>
</template>
