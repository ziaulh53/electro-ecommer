<template>
    <Layout>
        <a-spin :spinning="loading" tip="Verifying">
            <EShopSkeleton v-if="loading" height="300px" />
            <a-result v-if="!loading && !result" status="success" title="THANK YOU" sub-title="Your email is veryfied">
                <template #extra>
                    <EShopButton type="primary" btn-text="View Order" />
                    <router-link to="/signin">
                        <span class="bg-white py-2 px-5 border border-blue-500 rounded-md">Login</span>
                    </router-link>
                </template>
            </a-result>
            <a-result v-if="result" status="warning" title="We are sorry" sub-title="Something went wrong">
                <template #extra>
                    <EShopButton type="primary" btn-text="View Order" />
                    <router-link to="/">
                        <span class="bg-white py-2 px-5 border border-blue-500 rounded-md">Go Home</span>
                    </router-link>
                </template>
            </a-result>
        </a-spin>
    </Layout>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import { Layout } from '../components/Layout';
import { useRoute, useRouter } from 'vue-router'
import { api, auth } from '../api';
import { notify } from '../helpers';
import { EShopSkeleton } from '../components/shared';

const { query } = useRoute();
const router = useRouter();
const loading = ref(false);
const result = ref(false);

const handleVerify = async () => {
    loading.value = true;
    try {
        const res = await api.post(auth.changeEmail, { security_key: query.security_key });
        notify(res)
        if (!res.success) {
            //   router.push({name: 'login'})
            result.value = true;
        }
    } catch (error) {

    }
    loading.value = false
}

onMounted(() => {
    handleVerify();
})

</script>