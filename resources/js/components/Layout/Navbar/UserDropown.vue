<template>
    <a-dropdown placement="bottom">
        <img class="inline-block  mx-2 text-white font-semibold hover:bg-slate-600 w-[40px] h-[40px] rounded-full" :src="user?.user?.avatar ||'/assets/logo.png'" />
        <template #overlay>
            <a-menu class="px-2 w-[200px]">
                <a-menu-item class="mb-2 p-2">
                    <router-link to="/account">
                        <i class="fa-solid fa-user mr-1"></i> Account
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

const { userLogout, user } = useAuthStore();

const onLogout = () => {
    userLogout();
}
</script>