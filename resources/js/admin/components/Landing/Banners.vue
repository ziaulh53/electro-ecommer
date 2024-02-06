<template>
    <a-card bordered class="bg-slate-100 mb-5">
        <div class="font-semibold text-lg mb-2">Banners</div>
        <div class="grid grid-cols-4 gap-5 mb-5">
            <div v-for="url of bannerState" class="group border-2 p-3 bg-white rounded-lg relative" :key="url">
                <img :src="url || '/assets/logo.png'" class="w-full h-[200px] object-cover" />
                <div class="absolute hidden group-hover:flex py-2 justify-center left-0 bottom-3 bg-opacity-50 bg-white w-full">
                    <span class="cursor-pointer" :onclick="()=>handleDelete(url)"><i class="fa-solid fa-trash text-red-600 text-base"></i></span>
                    
                </div>
            </div>
            <div class="border-2 p-3 bg-white rounded-lg">
                <label for="banner-upload" class="w-full flex justify-center items-center h-[200px] border-2 border-dashed">
                    <span class="font-semibold p-2 bg-slate-200 border-2"> + Upload</span>
                </label>
                <input id="banner-upload" class="hidden" type="file" :onchange="handleFile"/>
            </div>
        </div>
        <div class="text-right">
            <EShopButton btn-text="Update" :onclick="handleUpdate" :disabled="disabled" />
        </div>
    </a-card>
</template>

<script setup>
import { ref, toRefs, computed } from 'vue';
import { EShopButton } from '../shared';
import { api, landingAdmin } from '../../../api';
import { notify } from '../../../helpers';

const props = defineProps({
    refetch: Function,
    banners: Array
})

const { banners, refetch } = toRefs(props)

const bannerState = ref(banners.value);

const disabled = computed(() => !bannerState.value?.length);

const handleFile = async (e) => {
    try {
        const images = bannerState.value || [];
        const res = await api.fileUpload(e.target.files[0]);
        images.push(res.result.url)
        bannerState.value = images;
    } catch (error) {
        console.log(error)
    }
}
const handleDelete = (url)=>{
    const images = bannerState.value.filter(imgUrl=> imgUrl != url);
    bannerState.value = images;
    console.log(url)
}
const handleUpdate = async () => {
    try {
        const res = await api.post(landingAdmin.updateBanner, { banners: bannerState.value });
        notify(res, refetch.value)
    } catch (error) {
        console.log(error)
    }
}

</script>