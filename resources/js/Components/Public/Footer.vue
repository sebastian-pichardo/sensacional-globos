<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage();
const shipping = computed(() => page.props.brand?.shipping ?? 'Envíos a todo México');
const social = computed(() => page.props.brand?.social ?? {});

const links = [
    { label: 'Nosotros', route: 'nosotros' },
    { label: 'Productos', route: 'productos' },
    { label: 'Encuentra un distribuidor', route: 'encuentra-un-distribuidor' },
    { label: 'Hazlo tú mismo', route: 'hazlo-tu-mismo' },
    { label: 'Inspírate', route: 'inspirate' },
];

const networks = computed(() => [
    { name: 'Instagram', href: social.value.instagram || '#' },
    { name: 'Facebook', href: social.value.facebook || '#' },
    { name: 'Pinterest', href: social.value.pinterest || '#' },
    { name: 'TikTok', href: social.value.tiktok || '#' },
    { name: 'YouTube', href: social.value.youtube || '#' },
]);
</script>

<template>
    <footer class="bg-gray-950 text-white">
        <div class="mx-auto grid max-w-7xl gap-10 px-4 py-12 sm:px-6 md:grid-cols-3 lg:px-8">
            <div>
                <img
                    src="/img/logo/logo-blanco.png"
                    alt="Globos Sensacionales"
                    class="h-32 w-auto"
                />
                <p class="mt-4 max-w-sm text-sm text-gray-300">
                    Fabricamos globos 100% de látex natural para distribuidores y puntos de venta.
                    Más de 30 años de calidad mexicana.
                </p>
                <p class="mt-3 text-sm font-semibold text-brand-yellow">
                    {{ shipping }}
                </p>
            </div>

            <nav aria-label="Pie de página">
                <p class="text-sm font-bold uppercase tracking-wide text-brand-cyan">
                    Secciones
                </p>
                <ul class="mt-4 space-y-2">
                    <li v-for="link in links" :key="link.route">
                        <Link
                            :href="route(link.route)"
                            class="text-sm text-gray-300 transition hover:text-brand-yellow"
                        >
                            {{ link.label }}
                        </Link>
                    </li>
                </ul>
            </nav>

            <div>
                <p class="text-sm font-bold uppercase tracking-wide text-brand-cyan">
                    Redes sociales
                </p>
                <ul class="mt-4 flex flex-wrap gap-3">
                    <li v-for="network in networks" :key="network.name">
                        <a
                            :href="network.href"
                            class="inline-flex rounded-full bg-white/10 px-4 py-2 text-sm font-medium hover:bg-brand-cyan hover:text-gray-900"
                            :target="network.href !== '#' ? '_blank' : undefined"
                            :rel="network.href !== '#' ? 'noopener noreferrer' : undefined"
                        >
                            {{ network.name }}
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="border-t border-white/10 py-4 text-center text-xs text-gray-400">
            <p>
                © {{ new Date().getFullYear() }} Pioneer Ballon. {{ shipping }}.
            </p>
            <p class="mt-2">
                <Link
                    :href="route('aviso-de-privacidad')"
                    class="text-gray-400 transition hover:text-brand-yellow"
                >
                    Aviso de Privacidad
                </Link>
            </p>
        </div>
    </footer>
</template>
