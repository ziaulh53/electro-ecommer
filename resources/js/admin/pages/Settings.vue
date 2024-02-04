<template>
    <Layout>
        <PageTitle title="Global variables" />
        <a-tabs v-model:activeKey="activeKey" centered>
            <a-tab-pane key="1">
                <template #tab>
                    <span>
                        <i class="fa-solid fa-copyright mr-2"></i>
                        Brand
                    </span>
                </template>
                <Brands />
            </a-tab-pane>
            <a-tab-pane key="2">
                <template #tab>
                    <span class="flex items-center">
                        <i class="fa-solid fa-palette mr-2"></i>
                        Color
                    </span>
                </template>
                <Colors />
            </a-tab-pane>
        </a-tabs>
    </Layout>
</template>

<script setup>
import { Layout } from '../components/Layout';
import { PageTitle } from '../components/shared';
import { ref } from 'vue';
import { Brands, Colors } from '../components/Settings';
const activeKey = ref('1');

</script>