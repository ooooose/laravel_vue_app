<script setup>
</script>

<template>
    <div v-if="$page.props.flash.status === 'success'" class="bg-blue-300 p-4 mb-2">
      {{ $page.props.flash.message }}
    </div>
    <div v-if="$page.props.flash.status === 'danger'" class="bg-red-300 p-4 mb-2">
      {{ $page.props.flash.message }}
    </div>
</template>