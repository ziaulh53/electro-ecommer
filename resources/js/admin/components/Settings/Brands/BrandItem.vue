<template>
    <a-card hoverable borderd>
        <template #cover class="w-[60px]">
            <img alt="example" :src="data.logo || '/assets/logo.png'"
                style="width: 60px !important; height: 60px; margin: 10px auto;object-fit: cover;" />
        </template>
        <template class="ant-card-actions" #actions>
            <EditBrand :data="data" :refetch="refetch"/>
            <a-popconfirm title="Are you sure?" ok-type="danger" @confirm="() => handleDelete(data._id, refetch)">
                <a href="#"><i class="fa-solid fa-trash text-red-600"></i></a>
            </a-popconfirm>
        </template>
        <a-card-meta :title="data.name">
        </a-card-meta>
    </a-card>
    
</template>

<script setup>
import { toRefs } from 'vue';
import EditBrand from './EditBrand.vue';
import { notify } from '../../../../helpers';
import { api, brandAdmin } from '../../../../api';

const props = defineProps({
    data: Object,
    refetch: Function
})
const { data, refetch, } = toRefs(props);

const handleDelete = async (id) => {
    try {
        const res = await api.delete(brandAdmin.deleteBrand, id);
        if (res.success) {
            notify(res);
            refetch.value();
        }
    } catch (error) {
        console.log(error)
    }
}


</script>