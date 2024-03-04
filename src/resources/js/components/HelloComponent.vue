<script setup>
import { onMounted } from 'vue';
import axios from 'axios';

const hello = async () => {
  try {
    const res = await axios.get("/api/hello");
    console.log(res);
  } catch (error) {
    console.error(error);
  }
};

onMounted(() => {
  hello();
});
</script>

<template>
  <div></div>
</template>
