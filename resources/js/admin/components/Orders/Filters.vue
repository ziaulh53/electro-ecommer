<template>
    <h4 class="text-lg font-semibold">Filters</h4>
    <div class="bg-slate-200 p-5 rounded-md">
        <div class="grid grid-cols-4 gap-x-5">
            <div>
                <div class="mb-2 font-bold">Date range</div>
                <a-range-picker v-model:value="datePicker" size="large" @change="handleDatePicker" :allow-clear="false"/>
            </div>
            <EShopInput type="text" label="Order ID" placeholder="Order id" v-model="filterState.orderId" />
            <div>
                <div class="font-bold mb-2">Status</div>
                <a-select v-model:value="filterState.status" class="w-full" size="large">
                    <a-select-option :value="ORDER_STATUS.Pending">{{ ORDER_STATUS.Pending }}</a-select-option>
                    <a-select-option :value="ORDER_STATUS.Cancelled">{{ ORDER_STATUS.Cancelled }}</a-select-option>
                    <a-select-option :value="ORDER_STATUS.Accepted">{{ ORDER_STATUS.Accepted }}</a-select-option>
                    <a-select-option :value="ORDER_STATUS.Shipped">{{ ORDER_STATUS.Shipped }}</a-select-option>
                    <a-select-option :value="ORDER_STATUS.Delivered">{{ ORDER_STATUS.Delivered }}</a-select-option>
                </a-select>
            </div>
            <EShopInput type="text" label="Email" v-model="filterState.email" />
            <EShopInput type="text" label="Phone" v-model="filterState.phone" />
        </div>
        <div class="text-end">
            <EShopButton btn-text="Clear" classes="mr-5" :onclick="clearFilter" :disabled="disabled"/>
            <EShopButton btn-text="Search" classes="" :onclick="handleSubmit" :disabled="disabled" />
        </div>
    </div>
</template>

<script setup>
import { ref, toRefs, computed } from 'vue';
import { EShopButton, EShopInput } from '../shared';
import { ORDER_STATUS } from '../../../constant';
import moment from 'moment';

const props = defineProps({
    filterSubmit: Function,
})
const { filterSubmit } = toRefs(props)
const filterState = ref({
    startDate: '',
    endDate: '',
    orderId: '',
    status: '',
    email: '',
    phone: ''
})
const datePicker = ref([]) 

const disabled = computed(() => !filterState.value.startDate && !filterState.value.endDate && !filterState.value.orderId && !filterState.value.status && !filterState.value.email && !filterState.value.phone)

const handleDatePicker = (value) => {
    if (value) {
        filterState.value.startDate = moment(String(value[0])).startOf('day').toString();
        filterState.value.endDate = moment(String(value[1])).endOf('day').toString();
    } else {
        filterState.value.startDate = '';
        filterState.value.endDate = '';
    }
}

const handleSubmit = () => {
    filterSubmit.value(filterState.value)
}

const clearFilter = () => {
    filterState.value = {
        startDate: '',
        endDate: '',
        orderId: '',
        status: '',
        email: '',
        phone: ''
    }
    filterSubmit.value({})
    datePicker.value = []
}
</script>