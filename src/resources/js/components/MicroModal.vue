<script setup>
import axios from 'axios';
import { ref, onMounted, reactive } from 'vue'

const isShow = ref(false)
const toggleStatus = () => { isShow.value = !isShow.value}
const search = ref('');
const customers = reactive({});

const seachCustomers = async () => {
  try {
    await axios.get(`/api/searchCustomers/?search=${search.value}`).then(
      res => {
        console.log(res.data)
        customers.value = res.data
      }
    )
    toggleStatus()
  } catch (e) {
    console.log(e)
  }
}

onMounted(() => {
  console.log(customers)
})

</script>
<template>
  <div v-show="isShow" class="modal" id="modal-1" aria-hidden="true">
    <div class="modal__overlay" tabindex="-1" data-micromodal-close>
      <div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="modal-1-title">
        <header class="modal__header">
          <h2 class="modal__title" id="modal-1-title">
            Micromodal
          </h2>
          <button type="button" class="modal__close" @click="toggleStatus"></button>
        </header>
        <main class="modal__content" id="modal-1-content">
          <p>
            Try hitting the <code>tab</code> key and notice how the focus stays within the modal itself. Also, <code>esc</code> to close modal.
          </p>
          <input name="customer" v-model="search"/>
          <button type="button" @click="seachCustomers">検索する</button>
        </main>
        <footer class="modal__footer">
          <button type="button" class="modal__btn modal__btn-primary">Continue</button>
          <button type="button" class="modal__btn" @click="toggleStatus">Close</button>
        </footer>
      </div>
    </div>
  </div>
  <button type="button" @click="toggleStatus">Open</button>
</template>
