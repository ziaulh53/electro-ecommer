<template>
    <EShopButton btn-text="Add Brand" iconClass="fa-solid fa-plus" :onclick="handleModal" />
    <a-modal v-model:open="open" title="Basic Modal" @ok="() => handleSubmit(refetch)"
        :ok-button-props="{ disabled: disabled || loading, loading: loading }">
        <div class="mb-5">
            <div class="mb-2 font-bold"><label>Name</label></div>
            <input type="text" class="w-full border-2 border-gray-300 rounded-lg p-2 px-4" placeholder=""
                v-model="brandData.name" name="name" />
        </div>
        <div class="mb-5">
            <div class="mb-2 font-bold"><label>Brand Logo</label></div>
            <div v-if="brandData.logo">
                <img :src="brandData.logo" class="h-[60px] w-[60px]" />
            </div>

            <div v-if="!brandData.logo" class="h-[200px] w-[150px] border-dashed border-2 bg-slate-100"></div>
            <div class="mt-5">
                <input type="file" :onchange="handleFile" />
            </div>
        </div>
    </a-modal>
</template>

<script setup>
import { ref, computed, toRefs } from 'vue'
import { EShopButton } from '../../shared';
import { api, brandAdmin } from '../../../../api';
import { notify } from '../../../../helpers';
const props = defineProps({
    refetch: Function
})
const {refetch} = toRefs(props)
const open = ref(false);

const brandData = ref({ name: '', logo: '' })
const loading = ref(false)
const disabled = computed(() => !brandData.value.name);
const handleSubmit = async () => {
    loading.value = true;
    try {
        const res = await api.post(brandAdmin.createBrand, { ...brandData.value })
        if (res.success) {
            notify(res);
            refetch.value();
            open.value = false;
        }

    } catch (error) {
    }
    loading.value = false
}

const handleFile = async (e) => {
    try {
        const res = await api.fileUpload(e.target.files[0]);
        brandData.value = { ...brandData.value, logo: res.result.url }
    } catch (error) {
        console.log(error)
    }
}

const handleModal = () => {
    open.value = true;
}

</script>