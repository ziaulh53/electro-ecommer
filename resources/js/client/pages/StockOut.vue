<template>
    <Layout>
        <div class="my-10">
            <a-result status="403" title="STOCK OUT!" sub-title="">
                <template #extra>
                    <router-link to="/">
                        <span class="bg-white py-2 px-5 border border-blue-500 rounded-md">Go Home</span>
                    </router-link>
                </template>
            </a-result>
        </div>
    </Layout>
</template>
<script setup>
import { Layout } from '../components/Layout';

</script>