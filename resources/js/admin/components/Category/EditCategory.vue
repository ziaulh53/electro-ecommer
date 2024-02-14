<template>
    <div @click="handleModal"><i class="fa-solid fa-pen-to-square"></i></div>
    <a-modal v-model:open="open" title="Basic Modal" :ok-button-props="{ disabled: disabled || loading }"
        @ok="() => handleSubmit(data?.id)" @cancel="handleClose">
        <div class="mb-5">
            <div class="mb-2 font-bold"><label>Name</label></div>
            <input type="text" class="w-full border-2 border-gray-300 rounded-lg p-2 px-4" placeholder=""
                v-model="categoryData.name" name="name" />
        </div>
        <!-- {{ allBrands }} -->
        <div class="mb-5">
            <div class="mb-2 font-bold"><label>Cover Image</label></div>
            <div v-if="categoryData.coverImage">
                <img :src="categoryData.coverImage" class="h-[60px] w-[60px]" />
            </div>

            <div v-if="!categoryData.coverImage" class="h-[200px] w-[150px] border-dashed border-2 bg-slate-100"></div>
            <div class="mt-5">
                <input type="file" :onchange="handleFile" />
            </div>
        </div>
    </a-modal>
</template>

<script setup>
import { ref, toRefs, computed } from 'vue';
import { api, categoryAdmin } from '../../../api';
import { notify } from '../../../helpers';

const props = defineProps({
    data: Object,
    refetch: Function
})

const { data, refetch } = toRefs(props)
const open = ref(false)
const loading = ref(false)
const categoryData = ref({ ...data.value })

const disabled = computed(() => !categoryData.value.name)

const handleModal = () => {
    open.value = true;
}
const handleClose = () => {
    open.value = false
}

// api call
const handleSubmit = async (id) => {
    loading.value = true;
    try {
        const { name, coverImage } = categoryData.value;
        const res = await api.put(categoryAdmin.getCategory, id, { name, coverImage });
        notify(res);
        handleClose();
        refetch.value();
    } catch (error) {
        console.log(error)
    }
    loading.value = false
}

const handleFile = async (e) => {
    try {
        const res = await api.fileUpload(e.target.files[0]);
        categoryData.value = { ...categoryData.value, coverImage: res.result.url }
    } catch (error) {
        console.log(error)
    }
}





</script>