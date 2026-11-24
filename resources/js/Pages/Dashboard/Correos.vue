<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { computed, ref } from "vue";

const props = defineProps({
    titulo: {
        type: String,
        required: true,
    },
    descripcion: {
        type: String,
        required: true,
    },
    exportUrl: {
        type: String,
        required: true,
    },
    columnas: {
        type: Array,
        required: true,
    },
    registros: {
        type: Array,
        required: true,
    },
});

const busqueda = ref("");

const filtrados = computed(() => {
    const termino = busqueda.value.trim().toLowerCase();
    if (!termino) {
        return props.registros;
    }

    return props.registros.filter((registro) =>
        props.columnas.some((columna) =>
            String(registro[columna.clave] ?? "")
                .toLowerCase()
                .includes(termino),
        ),
    );
});
</script>

<template>
    <Head :title="titulo" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <h2 class="text-xl font-semibold leading-tight text-gray-800">
                        {{ titulo }}
                    </h2>
                    <p class="mt-1 text-sm text-gray-500">
                        {{ descripcion }}
                    </p>
                </div>
                <a
                    v-if="registros.length > 0"
                    :href="exportUrl"
                    download
                    class="inline-flex items-center justify-center rounded-md bg-[#6b1a9b] px-4 py-2 text-sm font-semibold text-white transition hover:bg-[#581580]"
                >
                    Exportar PDF
                </a>
            </div>
        </template>

        <div class="py-8 sm:py-12">
            <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
                <div class="rounded-lg bg-white p-5 shadow-xs">
                    <p class="text-sm font-medium text-gray-500">
                        Correos registrados
                    </p>
                    <p class="mt-2 text-3xl font-semibold text-gray-900">
                        {{ registros.length }}
                    </p>
                </div>

                <section class="overflow-hidden rounded-lg bg-white shadow-xs">
                    <div class="border-b border-gray-100 px-5 py-4 sm:px-6">
                        <h3 class="text-base font-semibold text-gray-900">
                            Listado
                        </h3>
                        <p class="mt-1 text-sm text-gray-500">
                            Del registro más reciente al más antiguo.
                        </p>
                    </div>

                    <div
                        v-if="registros.length === 0"
                        class="px-5 py-10 text-center text-sm text-gray-500 sm:px-6"
                    >
                        Aún no hay correos registrados.
                    </div>

                    <template v-else>
                        <div class="px-5 py-4 sm:px-6">
                            <label for="buscar-correo" class="sr-only">
                                Buscar correo
                            </label>
                            <input
                                id="buscar-correo"
                                v-model="busqueda"
                                type="search"
                                placeholder="Buscar correo..."
                                class="h-10 w-full rounded-md border border-gray-300 px-3 text-sm text-gray-800 shadow-xs focus:border-[#6b1a9b] focus:ring-2 focus:ring-[#6b1a9b]/30 sm:max-w-sm"
                            />
                        </div>

                        <div
                            v-if="filtrados.length === 0"
                            class="px-5 pb-8 text-sm text-gray-500 sm:px-6"
                        >
                            Ningún correo coincide con la búsqueda.
                        </div>

                        <div v-else class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-100 text-sm">
                                <thead class="bg-gray-50 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                                    <tr>
                                        <th
                                            v-for="columna in columnas"
                                            :key="columna.clave"
                                            class="px-5 py-3 sm:px-6"
                                        >
                                            {{ columna.etiqueta }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 text-gray-700">
                                    <tr
                                        v-for="(registro, indice) in filtrados"
                                        :key="`${registro.email}-${indice}`"
                                    >
                                        <td
                                            v-for="columna in columnas"
                                            :key="`${indice}-${columna.clave}`"
                                            class="px-5 py-3 sm:px-6"
                                            :class="
                                                columna.clave === 'email'
                                                    ? 'font-medium text-gray-900'
                                                    : 'text-gray-600'
                                            "
                                        >
                                            {{ registro[columna.clave] }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </template>
                </section>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
