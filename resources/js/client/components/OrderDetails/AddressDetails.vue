<template>
    <div class="bg-white px-8 py-3 border border-gray-300 rounded-md">
        <div class="text-lg font-semibold uppercase mb-3"><i
                :class="type === 'billing' ? 'fa-solid fa-file-invoice mr-2' : 'fa-solid fa-home mr-2'"></i>{{ title }}
        </div>
        <p class="font-semibold text-lg">{{ data?.firstName + " " + data?.lastName }}</p>
        <p class="text-base">{{ data?.apartment }} , {{ data?.address }}</p>
        <p class="text-base">{{ data?.city }}, {{ data?.state }}-{{ data?.zipCode }} , {{ data?.country }}</p>
        <p class="text-base"> <i class="fa-solid fa-phone text-sm mr-2"></i>{{ data?.phone }}</p>

        <div v-if="type === 'billing'" class="mt-3">
            <div class="text-lg font-semibold uppercase mb-3">Payment Gateway</div>
            <p>Card type: <img :src="data?.method == 'Visa' ? '/assets/visa.png' : '/assets/master.png'"
                    class="inline-block h-[15px]" /> by <a href="https://stripe.com/en-gb-us" target="_blank"
                    class="font-bold italic text-blue-700">Stripe</a></p>
            <p>Card: * * * * * * {{ data?.last4 }}</p>
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