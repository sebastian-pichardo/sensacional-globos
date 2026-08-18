<script setup>
import DistributorPopup from '@/Components/Public/DistributorPopup.vue';
import FlashToast from '@/Components/Public/FlashToast.vue';
import Footer from '@/Components/Public/Footer.vue';
import Navbar from '@/Components/Public/Navbar.vue';
import SocialBar from '@/Components/Public/SocialBar.vue';
import WhatsAppButton from '@/Components/Public/WhatsAppButton.vue';

defineProps({
    overlayNav: {
        type: Boolean,
        default: false,
    },
});
</script>

<template>
    <div class="min-h-screen overflow-x-hidden bg-white font-sans text-gray-900">
        <Navbar :overlay="overlayNav" />
        <main>
            <slot />
        </main>
        <Footer />
        <SocialBar />
        <WhatsAppButton />
        <DistributorPopup />
        <FlashToast />
    </div>
</template>
