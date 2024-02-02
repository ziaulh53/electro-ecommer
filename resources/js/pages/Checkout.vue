<template>
    <Layout>
        <div class="my-10">
            <h4 class="text-2xl font-semibold uppercase mb-5">Checkout</h4>
            <div class="grid grid-cols-5 gap-5">
                <div class="col-span-3 bg-white border-2 border-gray-300 shadow-sm rounded-lg p-3">
                    <a-steps :current="current" class="mb-3">
                        <a-step title="Shipping">
                            <template #icon>
                                <i class="fa-solid fa-truck-fast"></i>
                            </template>
                        </a-step>
                        <a-step title="Billing">
                            <template #icon>
                                <i class="fa-solid fa-file-invoice"></i>
                            </template>
                        </a-step>
                        <a-step title="Pay">
                            <template #icon>
                                <i class="fa-solid fa-credit-card"></i>
                            </template>
                        </a-step>
                    </a-steps>
                    <div class="bg-slate-200 rounded-md p-5">
                        <Shipping v-if="current === 0" :handleShippingAddress="handleShippingAddress" />
                        <Billing v-if="current === 1" :billing-address="billingAddress" />
                        <Payment v-if="current === 2" :handlePayment="handlePayment" :total-price="totalPrice" />
                    </div>
                    <div class="text-right mt-5">
                        <EShopButton v-if="current > 0" btn-text="Previous" :onclick="handlePrev" class="mr-5" />
                        <EShopButton v-if="current < 2" btn-text="Next" :onclick="handleNext"
                            :disabled="(current == 0 && shippingDisabled) || (current == 1 && billingDisabled)" />
                    </div>

                </div>
                <div class="col-span-2">
                    <OrderItems :cartItems="userCart.shoppingCart" :totalPrice="totalPrice" />
                </div>
            </div>
        </div>
    </Layout>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { Layout } from '../components/Layout';
import { EShopButton } from '../components/shared';
import { OrderItems, Shipping, Billing, Payment } from '../components/Checkout';
import { useCartStore } from '../store'
import { api, orderEndpoint } from '../api';
import { notify } from '../helpers';
import { useRouter } from 'vue-router';

const router = useRouter();

const userCart = useCartStore();
const shippingAddress = ref({
    firstName: '',
    lastName: '',
    apertment: '',
    address: '',
    phone: '',
    city: '',
    state: '',
    country: '',
})
const billingAddress = ref({
    firstName: '',
    lastName: '',
    apertment: '',
    address: '',
    phone: '',
    city: '',
    state: '',
    country: ''
})
const current = ref(0);
const totalPrice = ref(0);

const shippingDisabled = computed(() => !shippingAddress?.value.firstName || !shippingAddress?.value.lastName || !shippingAddress?.value.firstName || !shippingAddress?.value.phone || !shippingAddress?.value.address || !shippingAddress?.value.city || !shippingAddress?.value.state || !shippingAddress?.value.country);
const billingDisabled = computed(() => !billingAddress?.value.firstName || !billingAddress?.value.lastName || !billingAddress?.value.firstName || !billingAddress?.value.phone || !billingAddress?.value.address || !billingAddress?.value.city || !billingAddress?.value.state || !shippingAddress?.value.country);

onMounted(() => {
    userCart.shoppingCart.forEach(({ discountAvailable, price, discountPrice, quantity }) => {
        totalPrice.value = totalPrice.value + ((discountAvailable ? discountPrice : price) * quantity);
    })
})

const handleNext = () => {
    current.value = current.value + 1;
}

const handlePrev = () => {
    current.value = current.value - 1;
}

//shippiung address
const handleShippingAddress = (value) => {
    shippingAddress.value = { ...value }
    billingAddress.value = { ...value }
}

// create order
const handlePayment = async (token) => {
    const items = userCart.shoppingCart?.map(item => ({
        ...item,
        brands: { name: item?.brands?.name, logo: item?.brands?.logo },
        category: { name: item?.category?.name }
    }))
    const res = await api.post(orderEndpoint.createOrder, { token, items, shippingAddress: shippingAddress.value, billingAddress: billingAddress.value })
    if (res.success) {
        notify(res);
        router.push({ name: 'order-confirmation' })
        userCart.clearCart()
    } else if (res?.isStockout) {
        notify(res);
        router.push({ name: 'stock-out' })
        userCart.clearCart()
    } else {
        notify(res)
    }
}

</script>