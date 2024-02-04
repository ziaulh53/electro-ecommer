<template>
    <a-dropdown placement="bottom">
        <a class="px-4 py-2  mx-2 text-white font-semibold hover:bg-slate-600" @click.prevent>
            Categories
            <!-- <DownOutlined /> -->
        </a>
        <template #overlay>
            <a-menu class="px-2 w-[200px]">
                <a-menu-item class="mb-2 p-2" v-for="cat of category" :key="cat?._id">
                    <router-link :to="'/category/'+cat?._id">
                        <img :src="cat?.coverImage" class="w-[10px] h-[10px] inline-block mr-2"/> {{ cat?.name }}
                    </router-link>
                </a-menu-item>
            </a-menu>
        </template>
    </a-dropdown>
</template>

<script setup>
defineProps({
    category: Array
})
</script>