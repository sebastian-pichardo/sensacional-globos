<script setup>
import { usePage } from '@inertiajs/vue3';
import { computed, ref, watch } from 'vue';

const page = usePage();
const message = computed(() => page.props.flash?.success || page.props.flash?.catalog || '');
const visible = ref(false);

watch(
    message,
    (value) => {
        visible.value = Boolean(value);
        if (value) {
            setTimeout(() => {
                visible.value = false;
            }, 5000);
        }
    },
    { immediate: true },
);
</script>

<template>
    <div
        v-if="visible && message"
        class="fixed bottom-24 left-1/2 z-50 w-[min(92vw,28rem)] -translate-x-1/2 rounded-xl bg-gray-900 px-4 py-3 text-center text-sm font-medium text-white shadow-lg"
        role="status"
    >
        {{ message }}
    </div>
</template>
