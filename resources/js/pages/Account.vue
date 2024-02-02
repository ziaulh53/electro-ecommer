<template>
    <Layout>
        <a-tabs tab-position="left">
            <a-tab-pane key="Orders">
                <template #tab>
                    <span>
                        <i class="fa-solid fa-file-invoice mr-2 text-base"></i>
                        <span class="font-bold text-lg">Orders</span>
                    </span>
                </template>
                <Order />
            </a-tab-pane>
            <a-tab-pane key="Wish List">
                <template #tab>
                    <span>
                        <i class="fa-solid fa-file-invoice mr-2 text-base"></i>
                        <span class="font-bold text-lg">Wish List</span>
                    </span>
                </template>
                <WishList />
            </a-tab-pane>
            <a-tab-pane key="Address">
                <template #tab>
                    <span>
                        <i class="fa-solid fa-house mr-2 text-base"></i>
                        <span class="font-bold text-lg">Address</span>
                    </span>
                </template>
                <Addresses />
            </a-tab-pane>
            <a-tab-pane key="Profile">
                <template #tab>
                    <span>
                        <i class="fa-solid fa-user mr-2 text-base"></i>
                        <span class="font-bold text-lg">Profile</span>
                    </span>
                </template>
                <Profile />
            </a-tab-pane>
        </a-tabs>
    </Layout>
</template>
<script setup>
import { Layout } from '../components/Layout';
import { Addresses, Order, Profile, WishList } from '../components/Account';

</script>