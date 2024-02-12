<template>
    <Layout>
        <a-result status="success" title="THANK YOU" sub-title="Your order is created and we start the work for next step">
            <template #extra>
                <RouterLink to="/account">
                    <EShopButton type="primary" btn-text="View Order" />
                </RouterLink>
                <router-link to="/">
                    <span class="bg-white py-2 px-5 border border-blue-500 rounded-md">Go Home</span>
                </router-link>
            </template>
        </a-result>
    </Layout>
</template>
<script setup>
import { Layout } from '../components/Layout';
import { EShopButton } from '../components/shared';

</script>