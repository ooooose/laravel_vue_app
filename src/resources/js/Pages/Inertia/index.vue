<script setup>
    import { Link } from '@inertiajs/vue3';

</script>

<template>
    <div v-if="$page.props.flash.message" class="bg-blue-300">
        {{ $page.props.flash.message }}
    </div>
    InertiaIndexです。<br />

    <a href="/">aタグ経由</a>
    <Link href="/">Link経由</Link>
</template>
