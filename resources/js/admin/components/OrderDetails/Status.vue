<template>
    <div class="mb-7 flex justify-between items-center">
        <h2 class="text-lg font-semibold">STATUS:
            <a-tag v-if="data?.status" :color="getStatusColor(data?.status)" class="text-lg uppercase">
                {{ data?.status }}
            </a-tag>
        </h2>
        <div class="flex items-center">
            <span class="mr-2 text-base font-semibold">Update Status: </span>
            <a-select ref="select" style="width: 150px" @focus="focus" size="large" @change="handleChange">
                <a-select-option :value="ORDER_STATUS.Pending">{{ ORDER_STATUS.Pending }}</a-select-option>
                <a-select-option :value="ORDER_STATUS.Cancelled">{{ ORDER_STATUS.Cancelled }}</a-select-option>
                <a-select-option :value="ORDER_STATUS.Accepted">{{ ORDER_STATUS.Accepted }}</a-select-option>
                <a-select-option :value="ORDER_STATUS.Shipped">{{ ORDER_STATUS.Shipped }}</a-select-option>
                <a-select-option :value="ORDER_STATUS.Delivered">{{ ORDER_STATUS.Delivered }}</a-select-option>
            </a-select>
        </div>
    </div>
    <a-modal v-model:open="open" title="CANCEL ORDER" ok-text="Cancel"
        :ok-button-props="{ danger: true, disabled, loading }" @ok="() => onUpdateStatus(ORDER_STATUS.Cancelled)">
        <EShopInput label="Type 'confirm'" v-model="confirm" placeholder="confirm" />
        <EShopInput label="Why cancelled this order?" v-model="cancelNote" placeholder="Short note" :is-text-area="true" />
    </a-modal>
    <a-modal v-model:open="openShipModal" title="Shipping Details" :ok-button-props="{type: 'primary', disabled:disabledShipped, loading }"
        @ok="() => onUpdateStatus(ORDER_STATUS.Shipped)">
        <EShopInput label="Provider name" v-model="logistic.name" placeholder="Company name" />
        <EShopInput label="Tracking url" v-model="logistic.trackingUrl" placeholder="tracking url" />
    </a-modal>
</template>

<script setup>
import { ref, computed, toRefs } from 'vue';
import { getStatusColor, notify } from '../../helpers';
import { EShopInput } from '../shared';
import { api, orderEndpoint } from '../../api';
import { ORDER_STATUS } from '../../constant';

const props = defineProps({
    data: Object,
    refetch: Function
})
const { data, refetch } = toRefs(props)

const open = ref(false);
const openShipModal = ref(false);
const confirm = ref("");
const cancelNote = ref("");
const logistic = ref({
    name: data?.logistics?.name,
    trackingUrl: data?.logistics?.trackingUrl
});
const loading = ref(false);

const disabled = computed(() => confirm.value !== 'confirm')
const disabledShipped = computed(() => !logistic.value.name || !logistic.value.trackingUrl)

const onUpdateStatus = async (status) => {
    loading.value = true;
    try {
        const res = await api.put(orderEndpoint.updateStatus, data?.value?._id, { status, logistics: logistic.value, cancelNote: cancelNote.value });
        notify(res, refetch.value())

    } catch (error) {
        console.log(error)
    }
    open.value = false;
    openShipModal.value = false;
    confirm.value = "";
    logistic.value = {
        name: '',
        trackingUrl: ''
    }
    loading.value = false;
}

const handleChange = (value) => {
    if (value === ORDER_STATUS.Cancelled) {
        open.value = true
    }
    else if (value === ORDER_STATUS.Shipped) {
        openShipModal.value = true
    } else {
        onUpdateStatus(value)
    }

}

</script>