<template>
    <header class="bg-white h-[60px] w-full">
        <div class="h-full p-5 flex items-center justify-between">
            <div>
                <div class="w-[250px] bg-slate-200 p-2 rounded-md flex items-center justify-between">
                    <input class="bg-slate-200 w-[200px] outline-none" />
                    <i class="fas fa-search cursor-pointer"></i>
                </div>
            </div>
            <div>
                <UserDropdown />
            </div>
        </div>
    </header>
</template>

<script setup>
import UserDropdown from './Navbar/UserDropown.vue'
</script>