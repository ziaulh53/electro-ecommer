<template>
    <a-card hoverable>
        <template #cover>
            <img alt="example"
                :src="data.coverImage || 'https://gw.alipayobjects.com/zos/rmsportal/JiqGstEfoWAOHiTxclqi.png'"
                style="width: 100px !important; height: 100px; margin: 10px auto; object-fit: cover;" />
        </template>
        <template class="ant-card-actions" #actions>
            <EditCategory :data="data" :refetch="refetch" />
            <a-popconfirm title="Are you sure?" ok-type="danger" @confirm="() => handleDelete(data._id)">
                <a href="#"><i class="fa-solid fa-trash text-red-600"></i></a>
            </a-popconfirm>
            <router-link :to="'/category/'+data._id"><i class="fa-solid fa-link"></i></router-link>
        </template>
        <a-card-meta :title="data.name" description="This is the description">
        </a-card-meta>
    </a-card>
</template>

<script setup>
import { toRefs } from 'vue';
import { api, categoryAdmin } from '../../../api';
import { notify } from '../../../helpers';
import EditCategory from './EditCategory.vue';

const props = defineProps({
    data: Object,
    refetch: Function
})
const { data, refetch } = toRefs(props);

const handleDelete = async (id) => {
    try {
        const res = await api.delete(categoryAdmin.deleteCategory, id);
        notify(res, refetch.value);
    } catch (error) {
        console.log(error)
    }
}


</script>