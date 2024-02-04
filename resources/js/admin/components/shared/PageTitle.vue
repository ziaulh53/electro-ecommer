<template>
    <div class="mb-2">
        <h2 class="text-2xl font-semibold uppercase">{{ title }}</h2>
        <div class="bg-theme-color h-[2px]"></div>
    </div>
</template>

<script setup>
defineProps({
    title: String
})
</script>