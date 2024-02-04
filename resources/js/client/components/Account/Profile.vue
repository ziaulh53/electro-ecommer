<template>
    <div class="mb-5">
        <BasicInfo />
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <ChangeEmail/>
        <ChangePassword/>
    </div>
</template>
<script setup>
import { BasicInfo, ChangeEmail, ChangePassword } from './Profile';
</script>