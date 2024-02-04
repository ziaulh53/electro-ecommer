<template>
    <EShopButton btn-text="Create Category" iconClass="fa-solid fa-plus" :onclick="handleModal" />
    <a-modal v-model:open="open" title="Basic Modal" @ok="handleSubmit" :ok-button-props="{ disabled: disabled }">
        <div class="mb-5">
            <div class="mb-2 font-bold"><label>Name</label></div>
            <input type="text" class="w-full border-2 border-gray-300 rounded-lg p-2 px-4" placeholder=""
                v-model="categoryData.name" name="name" />
        </div>
        <div class="mb-5">
            <div class="mb-2 font-bold"><label>Brands</label></div>
            <div>
                <a-select v-model:value="categoryData.brands" mode="multiple" placeholder="Inserted are removed"
                    class="w-full rounded-lg" size="large" >
                    <a-select-option v-for="brand of allBrands" :key="brand._id" :value="brand._id">{{ brand.name
                    }}</a-select-option>
                </a-select>
            </div>
        </div>
        <div class="mb-5">
            <div class="mb-2 font-bold"><label>Cover image</label></div>
            <div v-if="categoryData.coverImage">
                <img :src="categoryData.coverImage" class="h-[200px] w-[150px]" />
            </div>

            <div v-if="!categoryData.coverImage" class="h-[200px] w-[150px] border-dashed border-2 bg-slate-100"></div>
            <div class="mt-5">
                <input type="file" :onchange="handleFile" />
            </div>
        </div>
    </a-modal>
</template>

<script setup>
import { ref, computed, toRefs } from 'vue'
import { EShopButton } from '../shared';
import { api, category } from '../../api';
import { useBrandStore } from '../../store';
import { notify } from '../../helpers';
const props = defineProps({
    refetch: Function
})
const {refetch} = toRefs(props)
const brandStore = useBrandStore();
const allBrands = computed(() => brandStore.brand.map(({ _id, name }) => ({ _id, name })) || [])

const open = ref(false);

const categoryData = ref({ name: '', coverImage: '', brands: [] })
const loading = ref(false)
const disabled = computed(() => !categoryData.value.name || categoryData.value.brands.length === 0);
const handleSubmit = async () => {
    loading.value = true;
    try {
        const res = await api.post(category.createCategory, {...categoryData.value})
        notify(res, refetch.value)
        open.value = false;

    } catch (error) {
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

const handleModal = () => {
    open.value = true;
}


</script>