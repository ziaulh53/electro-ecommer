<template>
    <div class="bg-white px-8 py-3 border border-gray-300 rounded-md">
        <div class="text-lg font-semibold uppercase mb-3"><i
                :class="type === 'billing' ? 'fa-solid fa-file-invoice mr-2' : 'fa-solid fa-home mr-2'"></i>{{ title }}</div>
        <div class="font-bold text-base">{{ data?.firstName + " " + data?.lastName }}</div>
        <p class="text-base"> <i class="fa-solid fa-phone text-sm mr-2"></i>{{ data?.phone }}</p>
        <p class="text-base">{{ data?.apertment }}</p>
        <p class="text-base">{{ data?.address }}</p>
        <p class="text-base">{{ data?.city }}, {{ data?.zipCode }}</p>
        <p class="text-base">{{ data?.state }}, {{ data?.country }}.</p>

        <div v-if="type === 'billing'" class="mt-3">
            <div class="text-lg font-semibold uppercase mb-3">Payment Gateway</div>
            <p>Card type: <img :src="data?.cardType == 'visa' ? '/assets/visa.png' : '/assets/master.png'"
                    class="inline-block h-[15px]" /> by <a href="https://stripe.com/en-gb-us" target="_blank"
                    class="font-bold italic text-blue-700">Stripe</a></p>
            <p>Card: * * * * * * {{ data?.cardNo }}</p>
        </div>
    </div>
</template>

<script setup>
defineProps({
    data: Object,
    title: String,
    type: String
})
</script>