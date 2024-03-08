<script setup>
import { Link } from '@inertiajs/vue3';

</script>

<template>
    InertiaTestです。<br />

    <a href="/">aタグ経由</a>
    <Link href="/">Link経由</Link>
    <Link :href="route('inertia.index')">名前付きルートの確認です</Link>
    <Link :href="route('inertia.show', { id: 1 })">ルートパラメータのテストです</Link>
</template>
