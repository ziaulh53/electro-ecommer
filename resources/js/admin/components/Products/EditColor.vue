<template>
    <div class="mb-5">
        <div class="mb-2 font-bold"><label>Color</label></div>
        <div>
            <a-select v-model:value="colorState.color_id" placeholder="Inserted are removed" class="w-full rounded-lg"
                size="large">
                <a-select-option v-for="color of allColors" :key="color.id" :value="color.id">{{
                    color.colorName
                }}</a-select-option>
            </a-select>
        </div>
    </div>
    <EShopInput type="number" label="Quantity" v-model="colorState.quantity" />
    <div class="mb-2">
        <div class="mb-2 font-bold">Product images</div>
        <div v-for="url of colorState.images" :key="url" class="inline-block mr-2">
            <img :src="url" class="h-[150px] w-[100px]" />
        </div>
        <div v-if="!colorState.images.length" class="h-[200px] w-[150px] border-dashed border-2 bg-slate-100"></div>
        <div class="mt-5">
            <input type="file" multiple :onchange="handleFile" />
        </div>
    </div>
    <EShopButton btn-text="Update" :disabled="disabledColor" classes="w-full" :onclick="handleEditColor"
        :allColors="allColors" />
</template>

<script setup>
import { ref, toRefs, computed } from 'vue';
import { EShopButton, EShopInput } from '../shared';
import { api } from '../../../api';

const props = defineProps({
    colorstate: Object,
    handleUpdateColor: Function,
    idx: Number,
    allColors: Array,
    allBrands: Array
});
const { colorstate, handleUpdateColor, idx, allColors } = toRefs(props);
const colorState = ref({
    color_id: colorstate.value.color_id,
    images: colorstate.value.images,
    quantity: String(colorstate.value.quantity),
    colorName: colorstate.value?.colorName,
    colorCode: colorstate.value?.colorCode,
})


// color
const disabledColor = computed(() => !colorState.value.color_id || !colorState.value.quantity || !colorState.value.images.length)
const handleEditColor = () => {
    const { color_id, images, quantity } = colorState.value;
    const { colorName, colorCode } = allColors.value?.find(cl => cl.id === color_id);
    colorState.value = { color_id, colorName: colorName, colorCode, images, quantity: Number(quantity) };
    handleUpdateColor.value(colorState.value, idx.value)
}

const handleFile = async (e) => {
    let images = colorState.value.images;
    try {
        const files = e.target.files;
        for (var i = 0; i < files.length; i++) {
            const res = await api.fileUpload(files[i]);
            images.push(res.result.url);
        }
        colorState.value.images = images;
    } catch (error) {
        console.log(error)
    }
}

// submit
// const handleSubmit = async () => {
//     console.log(productData.value)
// }

</script>