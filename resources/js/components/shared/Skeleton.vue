<template>
    <div class="rounded-md w-full mx-auto">
        <div v-if="type=='box'" class="animate-pulse">
            <div class="bg-gray-300 rounded" :style="{height: height}"></div>
        </div>

        <div v-if="type==='content'" class="animate-pulse">
            <div v-for="(_,idx) of new Array(contenNumber).fill(null)" class="flex-1 space-y-3 py-1 mb-2" :key="idx">
                <div class="h-5 bg-slate-200 rounded mb-2"></div>
                <div class="space-y-3">
                    <div class="grid grid-cols-3 gap-4">
                        <div class="h-8 bg-slate-200 rounded col-span-2"></div>
                        <div class="h-8 bg-slate-200 rounded col-span-1"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
defineProps({
    type: {
        type: String,
        default: 'box',
        validator: value => ['box', 'circle', 'content'].indexOf(value) >= 0
    },
    height: {
        type: String,
        default: '400px'
    },
    contenNumber: {
        type: Number,
        default: 1
    } 
})
</script>