<template>
    <a-carousel autoplay>
        <div v-for="({imgUrl,id}) of posters" :key="id">
            <img :src="imgUrl || '/assets/poster.jpg'" class="w-full h-[200px] md:h-[400px] rounded-lg object-cover"/>
        </div>
    </a-carousel>
</template>

<script setup>

defineProps({
  posters: Array  
})
</script>