<template>
    <div class="relative">
        <swiper :modules="modules" :slides-per-view="1" :speed="300" :autoplay="autoplay" :space-between="50"
            :breakpoints="{
                546: {
                    slidesPerView: 2
                },
                768: {
                    slidesPerView: 3
                },
                1290: {
                    slidesPerView: 5
                }
            }" @swiper="onSwiper">
            <swiper-slide v-for="(data, idx) in items" :key="idx" :lazy="true">
                <Trending :data="data" />
            </swiper-slide>
        </swiper>
        <button
            class="bg-black bg-opacity-30 text-white w-[35px] h-[35px] rounded-full absolute z-10 left-0 top-1/2 transform -translate-y-1/2"
            @click="handlePrev">
            <span class="m-auto"><i class="fa-solid fa-angle-left"></i></span>
        </button>
        <button
            class="bg-black  bg-opacity-30 text-white w-[35px] h-[35px] rounded-full absolute z-10 right-0 top-1/2 transform -translate-y-1/2"
            @click="handleNext">
            <span class="m-auto"><i class="fa-solid fa-angle-right"></i></span>
        </button>
    </div>
</template>
  
<script setup>
import { ref, toRefs, } from 'vue';
import { Swiper, SwiperSlide } from 'swiper/vue';
import 'swiper/css';
import { Trending } from '../Home';

import { Autoplay } from 'swiper/modules';

const props = defineProps({
    items: Array,
    autoplay: {
        type: Boolean,
        default: true
    }
})

const { items } = toRefs(props)

const swiperRef = ref(null);
const modules = [Autoplay];
const onSwiper = (swiper) => {
    // Assign the swiper instance to the ref
    swiperRef.value = swiper;
};


const handleNext = () => {
    swiperRef.value?.slideNext();
};

const handlePrev = () => {
    swiperRef.value?.slidePrev();
};
</script>
  