<template>
    <Layout>
        <PageTitle title="Category" />
        <div class="my-5">
            <CreateCategory :refetch="getAllCategory"/>
        </div>
        <a-spin :spinning="loading">
            <div class="grid grid-cols-4 gap-5">
                <CategoryItem v-for="category of allCategory.categories" :key="category.id" :data="category"
                    :refetch="getAllCategory" />
            </div>
        </a-spin>
    </Layout>
</template>

<script setup>
import { Layout } from '../components/Layout';
import { PageTitle } from '../components/shared';
import { CategoryItem, CreateCategory } from '../components/Category'
import { api, categoryAdmin } from '../../api';
import { onMounted, ref } from 'vue';

const allCategory = ref('');
const loading = ref(false);


const getAllCategory = async () => {
    loading.value = true;
    allCategory.value = await api.get(categoryAdmin.getCategory);
    loading.value = false
}


onMounted(() => {
    getAllCategory();
})

</script>