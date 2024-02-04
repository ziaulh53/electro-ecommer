<template>
    <a-dropdown placement="bottom">
        <a class="px-4 py-2  mx-2 text-white font-semibold hover:bg-slate-600" @click.prevent>
            Categories
            <!-- <DownOutlined /> -->
        </a>
        <template #overlay>
            <a-menu class="px-2 w-[200px]">
                <a-menu-item class="mb-2 p-2">
                    <router-link to="/category">
                        <i class="fa-solid fa-mobile-screen-button mr-1"></i> Smart Phone
                    </router-link>
                </a-menu-item>
                <a-menu-item>
                    <router-link to="/category">
                        <i class="fa-solid fa-laptop mr-1"></i> Computers
                    </router-link>
                </a-menu-item>
                <a-menu-item>
                    <router-link to="/category">
                        <i class="fa-solid fa-headphones mr-1"></i> Headphones
                    </router-link>
                </a-menu-item>
            </a-menu>
        </template>
    </a-dropdown>
</template>