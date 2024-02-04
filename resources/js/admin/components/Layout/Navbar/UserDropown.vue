<template>
    <a-dropdown placement="bottom">
        <img class="px-4 py-2 inline-block  mx-2 text-white font-semibold hover:bg-slate-600" src="/assets/logo.png"
            width="60" />
        <template #overlay>
            <a-menu class="px-2 w-[200px]">
                <a-menu-item class="mb-2 p-2">
                    <router-link to="/category">
                        <i class="fa-solid fa-mobile-screen-button mr-1"></i> Account
                    </router-link>
                </a-menu-item>
                <a-menu-item>
                    <button :onclick="onLogout">
                        <i class="fa-solid fa-laptop mr-1"></i> Log out
                    </button>
                </a-menu-item>
            </a-menu>
        </template>
    </a-dropdown>
</template>

<script setup>
import { useAuthStore } from '../../../store';
const store = useAuthStore();

const onLogout = () => {
    store.userLogout();
}
</script>