<template>
    <span @click="handleModal" class="cursor-pointer"><i class="fa-solid fa-pen-to-square"></i></span>
    <a-modal v-model:open="open" title="Basic Modal" :ok-button-props="{ disabled: disabled || loading }"
        @ok="() => handleSubmit(data?._id)" @cancel="handleClose">
        <EShopInput v-model="colorData.colorName" placeholder="Color name" label="Color Name" />
        <EShopInput v-model="colorData.colorCode" placeholder="Color code" label="Color Code" />
    </a-modal>
</template>

<script setup>
import { ref, toRefs, computed } from 'vue';
import { api, color } from '../../../api';
import { notify } from '../../../helpers';
import { EShopInput } from '../../shared';

const props = defineProps({
    data: Object,
    refetch: Function
})
const { data, refetch } = toRefs(props)
const open = ref(false)
const loading = ref(false)
const colorData = ref({ ...data.value })

const disabled = computed(() => !colorData.value.colorName || !colorData.value.colorCode)

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
        const { colorName, colorCode } = colorData.value;
        const res = await api.put(color.editColor, id, { colorData: { colorName, colorCode: colorCode?.toLowerCase() } });
        notify(res);
        handleClose();
        refetch.value();
    } catch (error) {
        console.log(error)
    }
    loading.value = false
}

</script>