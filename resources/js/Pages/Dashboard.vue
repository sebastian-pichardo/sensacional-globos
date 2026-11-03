<script setup>
import DangerButton from "@/Components/DangerButton.vue";
import Modal from "@/Components/Modal.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, router, usePage } from "@inertiajs/vue3";
import { computed, ref } from "vue";

const props = defineProps({
    votaciones: {
        type: Object,
        required: true,
    },
});

const page = usePage();
const busqueda = ref("");
const correoAEliminar = ref(null);
const confirmarTodos = ref(false);
const eliminando = ref(false);

const lugares = [
    { clave: "primero", etiqueta: "Primer lugar", barra: "bg-[#e6692e]" },
    { clave: "segundo", etiqueta: "Segundo lugar", barra: "bg-[#6b1a9b]" },
    { clave: "tercero", etiqueta: "Tercer lugar", barra: "bg-[#c084fc]" },
];

const hayVotos = computed(() => props.votaciones.boletas > 0);

const correosFiltrados = computed(() => {
    const termino = busqueda.value.trim().toLowerCase();
    if (!termino) {
        return props.votaciones.correos;
    }

    return props.votaciones.correos.filter((boleta) =>
        boleta.email.toLowerCase().includes(termino),
    );
});

const cerrarConfirmacion = () => {
    if (eliminando.value) {
        return;
    }

    correoAEliminar.value = null;
    confirmarTodos.value = false;
};

const eliminarBoleta = () => {
    if (!correoAEliminar.value || eliminando.value) {
        return;
    }

    eliminando.value = true;
    router.delete(route("dashboard.votaciones.destroy"), {
        data: { email: correoAEliminar.value },
        preserveScroll: true,
        onFinish: () => {
            eliminando.value = false;
            correoAEliminar.value = null;
        },
    });
};

const eliminarTodos = () => {
    if (eliminando.value) {
        return;
    }

    eliminando.value = true;
    router.delete(route("dashboard.votaciones.destroy-all"), {
        preserveScroll: true,
        onFinish: () => {
            eliminando.value = false;
            confirmarTodos.value = false;
        },
    });
};

const porcentaje = (cantidad) => {
    if (!props.votaciones.boletas) {
        return 0;
    }

    return Math.round((cantidad / props.votaciones.boletas) * 100);
};

const formatearFecha = (iso) => {
    if (!iso) {
        return "—";
    }

    const fecha = new Date(iso);
    if (Number.isNaN(fecha.getTime())) {
        return iso;
    }

    return new Intl.DateTimeFormat("es-MX", {
        dateStyle: "medium",
        timeStyle: "short",
        timeZone: "America/Mexico_City",
    }).format(fecha);
};

const medalla = (posicion) => {
    if (posicion === 1) return "bg-[#e6692e] text-white";
    if (posicion === 2) return "bg-[#6b1a9b] text-white";
    if (posicion === 3) return "bg-[#f3e8ff] text-[#6b1a9b]";
    return "bg-gray-100 text-gray-600";
};
</script>

<template>
    <Head title="Votaciones" />

    <AuthenticatedLayout>
        <template #header>
            <div>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Votaciones Globoween 2
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    Marcador de la promoción de Halloween 2026
                </p>
            </div>
        </template>

        <div class="py-8 sm:py-12">
            <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
                <div
                    v-if="page.props.flash?.success"
                    class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm font-medium text-green-800"
                >
                    {{ page.props.flash.success }}
                </div>
                <div
                    v-if="page.props.errors?.votaciones"
                    class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-800"
                >
                    {{ page.props.errors.votaciones }}
                </div>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                    <div class="rounded-lg bg-white p-5 shadow-xs">
                        <p class="text-sm font-medium text-gray-500">
                            Boletas registradas
                        </p>
                        <p class="mt-2 text-3xl font-semibold text-gray-900">
                            {{ votaciones.boletas }}
                        </p>
                        <p class="mt-1 text-xs text-gray-500">
                            Un correo equivale a una boleta con tres lugares.
                        </p>
                    </div>

                    <div class="rounded-lg bg-white p-5 shadow-xs">
                        <p class="text-sm font-medium text-gray-500">
                            Va en primer lugar
                        </p>
                        <p class="mt-2 text-2xl font-semibold text-[#6b1a9b]">
                            {{ votaciones.lider ?? "Sin votos todavía" }}
                        </p>
                        <p class="mt-1 text-xs text-gray-500">
                            Desempata quien tenga más primeros lugares.
                        </p>
                    </div>

                    <div class="rounded-lg bg-white p-5 shadow-xs">
                        <p class="text-sm font-medium text-gray-500">
                            Cómo se cuentan los puntos
                        </p>
                        <ul class="mt-3 space-y-1 text-sm text-gray-700">
                            <li>
                                Primer lugar:
                                <strong>{{ votaciones.puntuacion.primero }} pts</strong>
                            </li>
                            <li>
                                Segundo lugar:
                                <strong>{{ votaciones.puntuacion.segundo }} pts</strong>
                            </li>
                            <li>
                                Tercer lugar:
                                <strong>{{ votaciones.puntuacion.tercero }} pt</strong>
                            </li>
                        </ul>
                    </div>
                </div>

                <section class="overflow-hidden rounded-lg bg-white shadow-xs">
                    <div class="border-b border-gray-100 px-5 py-4 sm:px-6">
                        <h3 class="text-base font-semibold text-gray-900">
                            Marcador por decoración
                        </h3>
                    </div>

                    <div
                        v-if="!hayVotos"
                        class="px-5 py-10 text-center text-sm text-gray-500 sm:px-6"
                    >
                        Aún no hay votos registrados en esta promoción.
                    </div>

                    <ul v-else class="divide-y divide-gray-100">
                        <li
                            v-for="item in votaciones.participantes"
                            :key="item.clave"
                            class="flex flex-col gap-4 px-5 py-5 sm:flex-row sm:items-center sm:px-6"
                        >
                            <div class="flex items-center gap-4 sm:w-64 sm:shrink-0">
                                <span
                                    class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full text-sm font-bold"
                                    :class="medalla(item.posicion)"
                                >
                                    {{ item.posicion }}
                                </span>
                                <img
                                    :src="item.imagen"
                                    :alt="item.nombre"
                                    class="h-16 w-16 rounded-md border border-gray-100 object-cover"
                                />
                                <div>
                                    <p class="font-semibold text-gray-900">
                                        {{ item.nombre }}
                                    </p>
                                    <p class="text-sm text-[#e6692e]">
                                        {{ item.puntos }}
                                        {{ item.puntos === 1 ? "pt" : "pts" }}
                                    </p>
                                </div>
                            </div>

                            <div class="min-w-0 flex-1 space-y-2">
                                <div
                                    v-for="lugar in lugares"
                                    :key="`${item.clave}-${lugar.clave}`"
                                    class="grid grid-cols-[7.5rem_1fr_auto] items-center gap-3 text-sm"
                                >
                                    <span class="text-gray-600">{{
                                        lugar.etiqueta
                                    }}</span>
                                    <div class="h-2 overflow-hidden rounded-full bg-gray-100">
                                        <div
                                            class="h-full rounded-full"
                                            :class="lugar.barra"
                                            :style="{
                                                width: `${porcentaje(item[lugar.clave])}%`,
                                            }"
                                        />
                                    </div>
                                    <span class="whitespace-nowrap text-right font-medium tabular-nums text-gray-800">
                                        {{ item[lugar.clave] }}
                                        <span class="font-normal text-gray-400">
                                            · {{ porcentaje(item[lugar.clave]) }}%
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </li>
                    </ul>
                </section>

                <section class="overflow-hidden rounded-lg bg-white shadow-xs">
                    <div class="flex flex-col gap-4 border-b border-gray-100 px-5 py-4 sm:flex-row sm:items-end sm:justify-between sm:px-6">
                        <div>
                            <h3 class="text-base font-semibold text-gray-900">
                                Correos registrados
                            </h3>
                            <p class="mt-1 text-sm text-gray-500">
                                {{ votaciones.correos.length }}
                                {{
                                    votaciones.correos.length === 1
                                        ? "boleta"
                                        : "boletas"
                                }}, de la más reciente a la más antigua.
                            </p>
                        </div>
                        <button
                            v-if="hayVotos"
                            type="button"
                            class="inline-flex items-center justify-center rounded-md border border-red-200 bg-white px-4 py-2 text-sm font-semibold text-red-700 transition hover:bg-red-50"
                            @click="confirmarTodos = true"
                        >
                            Eliminar todos los votos
                        </button>
                    </div>

                    <div
                        v-if="votaciones.correos.length === 0"
                        class="px-5 py-10 text-center text-sm text-gray-500 sm:px-6"
                    >
                        Cuando alguien vote, su correo aparecerá aquí.
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
                            v-if="correosFiltrados.length === 0"
                            class="px-5 pb-8 text-sm text-gray-500 sm:px-6"
                        >
                            Ningún correo coincide con la búsqueda.
                        </div>

                        <div v-else class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-100 text-sm">
                                <thead class="bg-gray-50 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                                    <tr>
                                        <th class="px-5 py-3 sm:px-6">Correo</th>
                                        <th class="px-4 py-3">Primer lugar</th>
                                        <th class="px-4 py-3">Segundo lugar</th>
                                        <th class="px-4 py-3">Tercer lugar</th>
                                        <th class="px-4 py-3">Fecha</th>
                                        <th class="px-5 py-3 sm:px-6">
                                            <span class="sr-only">Acciones</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 text-gray-700">
                                    <tr
                                        v-for="boleta in correosFiltrados"
                                        :key="boleta.email"
                                    >
                                        <td class="px-5 py-3 font-medium text-gray-900 sm:px-6">
                                            {{ boleta.email }}
                                        </td>
                                        <td class="px-4 py-3">{{ boleta.primero }}</td>
                                        <td class="px-4 py-3">{{ boleta.segundo }}</td>
                                        <td class="px-4 py-3">{{ boleta.tercero }}</td>
                                        <td class="whitespace-nowrap px-4 py-3 text-gray-500">
                                            {{ formatearFecha(boleta.votado_en) }}
                                        </td>
                                        <td class="px-5 py-3 text-right sm:px-6">
                                            <button
                                                type="button"
                                                class="font-semibold text-red-700 hover:text-red-800"
                                                @click="correoAEliminar = boleta.email"
                                            >
                                                Eliminar
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </template>
                </section>

                <Modal :show="correoAEliminar !== null" @close="cerrarConfirmacion">
                    <div class="p-6">
                        <h2 class="text-lg font-medium text-gray-900">
                            Eliminar votos de este correo
                        </h2>
                        <p class="mt-2 text-sm text-gray-600">
                            Se quitará la boleta de
                            <strong>{{ correoAEliminar }}</strong>
                            del marcador. Ese correo podrá volver a participar.
                        </p>
                        <div class="mt-6 flex justify-end gap-3">
                            <SecondaryButton @click="cerrarConfirmacion">
                                Cancelar
                            </SecondaryButton>
                            <DangerButton
                                :disabled="eliminando"
                                @click="eliminarBoleta"
                            >
                                {{ eliminando ? "Eliminando..." : "Eliminar" }}
                            </DangerButton>
                        </div>
                    </div>
                </Modal>

                <Modal :show="confirmarTodos" @close="cerrarConfirmacion">
                    <div class="p-6">
                        <h2 class="text-lg font-medium text-gray-900">
                            Eliminar todos los votos
                        </h2>
                        <p class="mt-2 text-sm text-gray-600">
                            {{
                                votaciones.boletas === 1
                                    ? "Se quitará la única boleta del marcador. Ese correo podrá volver a participar."
                                    : `Se quitarán las ${votaciones.boletas} boletas del marcador. Los correos podrán volver a participar.`
                            }}
                        </p>
                        <div class="mt-6 flex justify-end gap-3">
                            <SecondaryButton @click="cerrarConfirmacion">
                                Cancelar
                            </SecondaryButton>
                            <DangerButton
                                :disabled="eliminando"
                                @click="eliminarTodos"
                            >
                                {{ eliminando ? "Eliminando..." : "Eliminar todos" }}
                            </DangerButton>
                        </div>
                    </div>
                </Modal>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
