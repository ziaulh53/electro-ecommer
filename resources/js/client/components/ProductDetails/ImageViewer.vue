<template>
    <div class="border-r-2 pr-10 border-gray-300">
        <VueMagnifier :src="images[idx] || '/assets/logo.png'"
            class-name="w-[300px] object-cover mb-4" height="500" style="{object-fit: cover;}" />
        <div class="flex justify-start">
            <div v-for="(url, index) of images" :key="url" @click="()=>onSelectImage(index)"
                class="w-[70px] h-[70px] border-2 border-gray-400 cursor-pointer mr-2 relative">
                <img :src="url || '/assets/logo.png'" class="w-full h-full" />
                <div v-if="index!==idx" class="absolute bg-black bg-opacity-40 w-full h-full top-0"></div>
            </div>
        </div>
    </div>
</template>

<script setup>
import VueMagnifier from '@websitebeaver/vue-magnifier'
import '@websitebeaver/vue-magnifier/styles.css'
import { ref } from 'vue';

const props = defineProps({
    images : Array
})

const idx = ref(0);

const onSelectImage = (index)=>{
    idx.value = index
}

</script>