<template>
     <div class="max-w-[400px]">
          <div class="mb-5">
               <div class="font-semibold text-gray-600 mb-1">Card Number</div>
               <div ref="cardNumberElement" id="card-number"></div>
          </div>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
               <div>
                    <div class="font-semibold text-gray-600 mb-1">Expiry</div>
                    <div ref="cardExpiryElement" id="card-expiry"></div>
               </div>
               <div>
                    <div class="font-semibold text-gray-600 mb-1">CVC</div>
                    <div ref="cardCvcElement" id="card-cvc"></div>
               </div>
          </div>
          <div class="flex items-center">
               <p class="text-gray-400 font-semibold mr-2">Your payment secured by </p>
               <a href="https://stripe.com/docs/security" target="_blank">
                    <i class="fa-brands fa-stripe text-blue-500 text-4xl mt-2"></i>
               </a>
          </div>

          <div class="text-right mt-5">
               <EShopButton :loading="loading" :btn-text="'Pay USD ' + (totalPrice + 80)" :onclick="onPayment" />
          </div>
     </div>
</template>
   
<script setup>
import { ref, onMounted, toRefs } from 'vue';
import { STRIPE_PK } from '../../api';
import { loadStripe } from '@stripe/stripe-js';
import { EShopButton } from '../shared';

const props = defineProps({
     handlePayment: Function,
     totalPrice: Number
})

const { handlePayment, totalPrice } = toRefs(props)

const cardNumberElement = ref(null);
const cardExpiryElement = ref(null);
const cardCvcElement = ref(null);
const stripe = ref(null);
const loading = ref(null);

onMounted(() => {
     setupCardElement();
});
const setupCardElement = async () => {
     stripe.value = await loadStripe(STRIPE_PK);
     const elements = stripe.value.elements();
     const cardNumber = elements.create('cardNumber', { showIcon: true, });
     const cardExpiry = elements.create('cardExpiry');
     const cardCvc = elements.create('cardCvc');
     cardNumber.mount('#card-number');
     cardExpiry.mount('#card-expiry');
     cardCvc.mount("#card-cvc");
     cardNumber.on('change', event => {
          // Handle validation errors and update UI accordingly
          // numberDisabled.value = !event.complete
     });
     cardNumberElement.value = cardNumber;
     cardExpiryElement.value = cardExpiry;
     cardCvcElement.value = cardCvc;
};

const onPayment = async () => {
     loading.value = true
     const { token } = await stripe.value.createToken(cardNumberElement.value);
     if (token?.id) {
          handlePayment.value(token)
     }
     loading.value = false;
};

</script>
   
<style>
#card-number,
#card-cvc,
#card-expiry {
     padding: 12px;
     background-color: white;
     border-radius: 5px;
     border: 1px solid lightgray;
     box-shadow: 1px 2px 1px 0px #dad8d8;
}

/* #card-number>input {} */
</style>
   