<template>
    <div>
        <h2 class="text-lg font-semibold uppercase mb-5">Order Items:</h2>
        <a-table :columns="columns" :data-source="[...data, { totalPrice, lastChild: true }]" :pagination="false">
            <template #bodyCell="{ column, record }">
                <template v-if="column.key === 'image'">
                    <img v-if="!record.lastChild" :src="record?.images[0]" class="w-[100px] h-[100px]" />
                </template>
                <template v-if="column.key === 'unit-price'">
                    <span v-if="!record.lastChild">USD {{ record?.discountAvailable ? record?.discountPrice : record?.price
                    }}</span>
                </template>
                <template v-if="column.key === 'price'">
                    <span v-if="!record.lastChild" class="text-right">USD {{ (record?.discountAvailable ?
                        record?.discountPrice
                        : record?.price) * record.quantity }}</span>
                    <div v-if="record.lastChild" class="text-base font-bold">
                        <div>Shipping Charge: USD 80</div>
                        <div>Total Price: USD {{ totalPrice+80 }}</div>
                    </div>
                </template>
            </template>
        </a-table>
    </div>
</template>

<script setup>
import { ref, toRefs, onMounted } from 'vue';

const props = defineProps({
    data: Array
})
const {data} = toRefs(props)
const totalPrice = ref(0);

onMounted(()=>{
    data.value?.forEach(prod=>{
        totalPrice.value+= (prod?.discountAvailable? prod?.discountPrice:prod?.price)* prod?.quantity
    })
})


const columns = [
    {
        title: '#',
        key: 'image',
    },
    {
        title: 'Product',
        dataIndex: 'name',
        key: 'name',
    },
    {
        title: 'Unit Price',
        key: 'unit-price',
    },
    {
        title: 'Quantity',
        dataIndex: 'quantity',
        key: 'quantity'
    },
    {
        title: 'Price',
        key: 'price',
    },

]
</script>