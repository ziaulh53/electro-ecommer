<template>
    <div class="mb-5 flex justify-between items-center">
        <h2 class="text-lg font-semibold">STATUS:
            <a-tag v-if="data?.status" :color="getStatusColor(data?.status)" class="text-lg uppercase">
                {{ data?.status }}
            </a-tag>
        </h2>
        <div v-if="data?.status === 'Pending'">
            <span class="bg-red-600 px-5 py-1 rounded-md text-white font-semibold cursor-pointer" @click="openModal">Cancel Order</span>
        </div>
    </div>
    <a-modal v-model:open="open" title="CANCEL ORDER" ok-text="Delete" :ok-button-props="{danger: true, disabled, loading }" @ok="handleSubmit">
        <EShopInput label="Type 'confirm'" v-model="confirm" placeholder="confirm"/>
    </a-modal>
</template>

<script setup>
import { ref, computed, toRefs } from 'vue';
import { getStatusColor, notify } from '../../../helpers';
import { EShopInput } from '../shared';
import { api, orderEndpoint } from '../../../api';

const props = defineProps({
    data: Object,
    refetch: Function
})
const {data, refetch} = toRefs(props)

const open = ref(false);
const confirm = ref("");
const loading = ref(false);

const disabled = computed(()=> confirm.value!=='confirm')

const openModal = () => {
    open.value = true
}

const handleSubmit = async()=>{
    loading.value = true;
    
    try {
        const res = await api.put(orderEndpoint.updateStatus, data?.value?._id, {status: 'Cancelled'});
        notify(res, refetch.value())
        
    } catch (error) {
        console.log(error)
    }
    open.value = false
    confirm.value = ""
}

</script>