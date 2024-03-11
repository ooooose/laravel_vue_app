<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue'
import InputLabel from '@/Components/InputLabel.vue'
import TextInput from '@/Components/TextInput.vue'
</script>

<template>

<GuestLayout>
    文字を何か書く
    <InputLabel value="件名">
        タイトル
    </InputLabel>
    <TextInput modelValue="初期値が入ります"></TextInput>
</GuestLayout>

</template>
