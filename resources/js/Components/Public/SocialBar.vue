<script setup>
import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage();
const social = computed(() => page.props.brand?.social ?? {});

const networks = computed(() => [
    {
        name: 'Instagram',
        href: social.value.instagram || '#',
        color: 'hover:bg-brand-purple',
        path: 'M7 3h10a4 4 0 014 4v10a4 4 0 01-4 4H7a4 4 0 01-4-4V7a4 4 0 014-4zm5 4.5A4.5 4.5 0 1016.5 12 4.5 4.5 0 0012 7.5zm0 7.4A2.9 2.9 0 1114.9 12 2.9 2.9 0 0112 14.9zM17.7 6.3a1.05 1.05 0 11-1.05-1.05 1.05 1.05 0 011.05 1.05z',
    },
    {
        name: 'Facebook',
        href: social.value.facebook || '#',
        color: 'hover:bg-[#1877F2]',
        path: 'M15 8h-2a1 1 0 00-1 1v2h3l-.5 3H12v7H9v-7H7v-3h2V8.5A3.5 3.5 0 0112.5 5H15v3z',
    },
    {
        name: 'Pinterest',
        href: social.value.pinterest || '#',
        color: 'hover:bg-[#E60023]',
        fillRule: 'evenodd',
        path: 'M12 2C6.5 2 2 6.5 2 12c0 4.1 2.5 7.6 6 9.1-.1-.8-.2-2 0-2.8.2-.8 1.1-4.8 1.1-4.8s-.3-.6-.3-1.4c0-1.3.8-2.3 1.7-2.3.8 0 1.2.6 1.2 1.3 0 .8-.5 2-.8 3.1-.2.9.5 1.7 1.4 1.7 1.7 0 3-1.8 3-4.3 0-2.3-1.6-3.9-4-3.9-2.7 0-4.3 2-4.3 4.1 0 .8.3 1.7.7 2.2l.1.2-.2 1.1c0 .2-.1.2-.3.1-1.2-.5-2-2.3-2-3.7 0-3 2.2-5.8 6.3-5.8 3.3 0 5.9 2.4 5.9 5.5 0 3.3-2.1 5.9-5 5.9-1 0-1.9-.5-2.2-1.1l-.6 2.3c-.2.8-.8 1.9-1.2 2.5.9.3 1.8.4 2.8.4 5.5 0 10-4.5 10-10S17.5 2 12 2z',
    },
    {
        name: 'TikTok',
        href: social.value.tiktok || '#',
        color: 'hover:bg-gray-900',
        path: 'M14 4c.4 2.4 1.8 4 4 4.4V11c-1.5 0-2.9-.5-4-1.3V15a5 5 0 11-5-5c.3 0 .7 0 1 .1V13a2.2 2.2 0 00-.9-.2 2 2 0 102 2V4h2.9z',
    },
    {
        name: 'YouTube',
        href: social.value.youtube || '#',
        color: 'hover:bg-[#FF0000]',
        fillRule: 'evenodd',
        path: 'M23.5 6.2a3 3 0 00-2.1-2.1C19.5 3.5 12 3.5 12 3.5s-7.5 0-9.4.6A3 3 0 00.5 6.2 31 31 0 000 12a31 31 0 00.5 5.8 3 3 0 002.1 2.1c1.9.5 9.4.5 9.4.5s7.5 0 9.4-.5a3 3 0 002.1-2.1A31 31 0 0024 12a31 31 0 00-.5-5.8zM9.5 15.6V8.4L15.8 12z',
    },
]);
</script>

<template>
    <aside
        class="fixed z-40 flex flex-col gap-2 max-md:bottom-24 max-md:left-3 md:left-3 md:top-1/2 md:-translate-y-1/2"
        aria-label="Redes sociales"
    >
        <a
            v-for="network in networks"
            :key="network.name"
            :href="network.href"
            :target="network.href !== '#' ? '_blank' : undefined"
            :rel="network.href !== '#' ? 'noopener noreferrer' : undefined"
            class="flex h-10 w-10 items-center justify-center rounded-full bg-brand-cyan text-white shadow-md transition hover:scale-110"
            :class="network.color"
            :aria-label="network.name"
        >
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                <path :d="network.path" :fill-rule="network.fillRule" :clip-rule="network.fillRule" />
            </svg>
        </a>
    </aside>
</template>
