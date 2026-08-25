<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { computed, onMounted, onUnmounted, ref } from 'vue';

const props = defineProps({
    overlay: {
        type: Boolean,
        default: false,
    },
});

const page = usePage();
const shipping = computed(() => page.props.brand?.shipping ?? 'Envíos a todo México');
const open = ref(false);
const scrolled = ref(false);

const links = [
    { label: 'Nosotros', route: 'nosotros' },
    { label: 'Productos', route: 'productos' },
    { label: 'Encuentra un distribuidor', route: 'encuentra-un-distribuidor' },
    { label: 'Hazlo tú mismo', route: 'hazlo-tu-mismo' },
    { label: 'Inspírate', route: 'inspirate' },
];

const onScroll = () => {
    scrolled.value = window.scrollY > 48;
};

onMounted(() => {
    onScroll();
    window.addEventListener('scroll', onScroll, { passive: true });
});

onUnmounted(() => {
    window.removeEventListener('scroll', onScroll);
});

const navSolid = computed(() => !props.overlay || scrolled.value || open.value);
const navVisible = computed(() => !props.overlay || scrolled.value || open.value);
</script>

<template>
    <header
        class="fixed inset-x-0 top-0 z-40 transition-[transform,opacity] duration-500 ease-out"
        :class="
            navVisible
                ? 'translate-y-0 opacity-100'
                : 'pointer-events-none -translate-y-full opacity-0'
        "
    >
        <p
            class="bg-brand-red px-4 py-1.5 text-center text-xs font-semibold uppercase tracking-wide text-white sm:text-sm"
        >
            {{ shipping }}
        </p>

        <nav
            class="transition-colors duration-300"
            :class="
                navSolid
                    ? 'border-b border-gray-100 bg-white/95 shadow-sm backdrop-blur'
                    : 'bg-transparent'
            "
            aria-label="Principal"
        >
            <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4 py-3 sm:px-6 lg:px-8">
                <Link :href="route('home')" class="flex shrink-0 items-center">
                    <img
                        src="/img/logo/logo-globos-sensacional.png"
                        alt="Globos Sensacionales"
                        class="h-16 w-auto sm:h-20 lg:h-[5.25rem]"
                    />
                </Link>

                <ul class="hidden items-center gap-4 xl:gap-6 lg:flex">
                    <li v-for="link in links" :key="link.route">
                        <Link
                            :href="route(link.route)"
                            class="text-sm font-semibold uppercase tracking-wide transition-colors xl:text-base"
                            :class="
                                route().current(link.route)
                                    ? 'text-brand-red'
                                    : navSolid
                                      ? 'text-gray-800 hover:text-brand-cyan'
                                      : 'text-gray-900 hover:text-brand-red'
                            "
                        >
                            {{ link.label }}
                        </Link>
                    </li>
                </ul>

                <button
                    type="button"
                    class="inline-flex items-center justify-center rounded-md p-2 text-gray-800 lg:hidden"
                    :aria-expanded="open"
                    aria-controls="menu-movil"
                    aria-label="Abrir menú"
                    @click="open = !open"
                >
                    <svg
                        v-if="!open"
                        class="h-7 w-7"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"
                        />
                    </svg>
                    <svg
                        v-else
                        class="h-7 w-7"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"
                        />
                    </svg>
                </button>
            </div>

            <div
                v-show="open"
                id="menu-movil"
                class="border-t border-gray-100 bg-white lg:hidden"
            >
                <ul class="space-y-1 px-4 py-3">
                    <li v-for="link in links" :key="link.route">
                        <Link
                            :href="route(link.route)"
                            class="block rounded-md px-3 py-3 text-base font-semibold uppercase tracking-wide text-gray-800 hover:bg-brand-cyan/10 hover:text-brand-cyan"
                            @click="open = false"
                        >
                            {{ link.label }}
                        </Link>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
</template>
