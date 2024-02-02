<template>
    <div class="relative min-h-screen">
        <div class="bg-yellow-100 flex items-center justify-between h-[40px] px-8 md:px-24">
            <div></div>
            <div class="font-[200]"><span>Hot Line:</span> <a href="tel:909999999" class="underline">909999999</a></div>
        </div>
        <div class="hidden md:block">
            <Navbar />
        </div>

        <main class="px-5 lg:px-20 h-full">
            <div class="my-10 min-h-[49vh]">
                <slot></slot>
            </div>
        </main>
        <CustomFooter />
        <div class="sticky md:hidden justify-between bottom-0 z-[1005] w-full px-8 py-5 bg-[#ebebd4] shadow-2xl shadow-black rounded-t-2xl border-slate-200">
            <MobileNavigation />
        </div>
    </div>
</template>

<script setup>
import Navbar from './NavBar.vue';
import CustomFooter from './CustomFooter.vue';
import MobileNavigation from './MobileNavigation.vue';
</script>