<template>
    <div class="bg-theme-color">
        <div class="grid grid-cols-1 md:grid-cols-3 px-20">
            <div class="text-white py-10 text-center md:text-start">
                <div class="flex items-center justify-center md:justify-start mb-3"><img :src="'/assets/logo.png'"
                        class="w-[50px] mr-5 " />
                    <h1 class="text-2xl font-bold">E-Shop</h1>
                </div>
                <p class="text-sm">Largest e-commerce platform in Bangladesh</p>
            </div>
            <div class="text-white py-10 text-center md:mx-auto">
                <h6 class="font-semibold text-lg mb-3">Quick Links</h6>
                <ul class="text-sm">
                    <li>Account</li>
                    <li>Orders</li>
                </ul>
            </div>
            <div class="text-white py-10 text-center md:text-right">
                <h6 class="font-semibold text-lg mb-3">Contact us</h6>
                <div class="">
                    <div class="text-sm mb-2">
                        <p class="mb-1">House #14, Road # 02,</p>
                        <p class="mb-1">Akhalia, Sylhet-3100.</p>
                        <p>Email: support@e-shop.com</p>
                    </div>
                    Follow Us: <i class="fa-brands fa-facebook mx-2"></i> <i class="fa-brands fa-twitter"></i>
                </div>
            </div>
        </div>
    </div>
</template>