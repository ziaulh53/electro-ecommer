<template>
    <div class="my-5">
        <CreateColor :refetch="getAllColors" />
    </div>
    <a-spin :spinning="loading">
        <a-table :dataSource="allColors.result" :columns="columns">
            <template #action="{ record }">
                <a-popconfirm title="Are you sure?" ok-type="danger" @confirm="() => handleDelete(record._id)">
                    <span class="mr-2">
                        <i class="fa-solid fa-trash-can text-red-500"></i>
                    </span>
                </a-popconfirm>
                <EditColor :refetch="getAllColors" :data="record"/>
            </template>
            <template #colorView="{record}">
                <div :class="'h-[20px] w-[20px] border-2 border-black rounded-full'" :style="{'background': record.colorCode}"></div>
            </template>
        </a-table>
    </a-spin>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { api, colorAdmin } from '../../../../api';
import CreateColor from './CreateColor.vue';
import EditColor from './EditColor.vue';

const allColors = ref('');
const loading = ref(false);

const columns = [
    {
        title: 'Color Name',
        dataIndex: 'colorName',
        key: 'colorName'
    },
    {
        title: 'Color Code',
        dataIndex: 'colorCode',
        key: 'colorCode'
    },
    {
        title: 'Color View',
        key: 'colorView',
        slots: { customRender: 'colorView' },
    },
    {
        title: 'Action',
        key: 'action',
        slots: { customRender: 'action' },
    }

]


// fetch colors
const getAllColors = async () => {
    loading.value = true;
    allColors.value = await api.get(color.getColors);
    loading.value = false
}

onMounted(() => {
    getAllColors();
})

// delete colors
const handleDelete= async(id)=>{
    try {
        const res = await api.delete(colorAdmin.deleteColor, id);
        if (res.success) {
            notify(res);
            getAllColors()
        }
    } catch (error) {
        console.log(error)
    }
}

</script>