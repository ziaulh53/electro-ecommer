<template>
    <EShopButton btn-text="Add Color" iconClass="fa-solid fa-plus" :onclick="handleModal" />
    <a-modal v-model:open="open" title="Basic Modal" @ok="() => handleSubmit(refetch)"
        :ok-button-props="{ disabled: disabled || loading, loading: loading }">
        <EShopInput v-model="colorData.colorName" placeholder="Color Name" label="Color Name" />
        <EShopInput v-model="colorData.colorCode" placeholder="hexa color code" label="Color Code" />

    </a-modal>
</template>

<script setup>
import { ref, computed, toRefs } from 'vue'
import { EShopButton, EShopInput } from '../../shared';
import { api, color } from '../../../api';
import { notify } from '../../../helpers';
const props = defineProps({
    refetch: Function
})
const { refetch } = toRefs(props)
const open = ref(false);

const colorData = ref({ colorName: '', colorCode: '' })
const loading = ref(false)
const disabled = computed(() => !colorData.value.colorName || !colorData.value.colorCode);
const handleSubmit = async () => {
    loading.value = true;
    try {
        const res = await api.post(color.createColor, { ...colorData.value, colorCode: colorData.value.colorCode.toLowerCase() })
        if (res.success) {
            notify(res);
            refetch.value();
            open.value = false;
        }

    } catch (error) {
    }
    loading.value = false
}


const handleModal = () => {
    open.value = true;
}




</script>