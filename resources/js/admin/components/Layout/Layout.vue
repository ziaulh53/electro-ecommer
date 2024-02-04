<template>
    <div class="flex mb-5">
        <div class="h-[60px] w-[250px] bg-white">
            <p class="text-2xl text-center">LOGO</p>
        </div>
        <main class="w-full mx-5">
            <Navbar />
        </main>

    </div>
    <div class="flex">
        <div class="min-h-screen bg-theme-color w-[250px]">
            <div v-for="menu of sideBar" :key="menu.path" class="p-2 mx-3 my-3 text-white text-lg">
                <router-link :to="menu.path" class="ml-2">
                    <i :class="menu.iconClass+' mr-2'"></i><span>{{ menu.label }}</span>
                </router-link>
            </div>
        </div>

        <main class="h-full w-full  mx-5">
            <div class="p-5 rounded-md min-h-[80vh] bg-white">
                <Spin :spinning=" loading ">
                    <slot></slot>
                </Spin>
            </div>
        </main>



    </div>
</template>

<script setup>
import Navbar from './NavBar.vue';
import { Spin } from 'ant-design-vue';
import { sideBar } from './sideBar'

defineProps({
    loading: Boolean
})
</script>