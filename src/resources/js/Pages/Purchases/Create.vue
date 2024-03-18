<script setup>
import { getToday } from '@/common'
import { ref, computed } from 'vue'
import { onMounted, reactive } from 'vue';

const props = defineProps({
    'customers': Array,
    'items': Array
})

const itemList = ref([])

onMounted(() => {
    form.date = getToday()
    props.items.forEach(item => {
        itemList.value.push({
            id: item.id, name: item.name, price: item.price, quantity: 0
        })
    })
})

const totalPrice = computed(() => {
    let total = 0
    itemList.value.forEach(item => {
        total += item.price * item.quantity
    })
    return total
})

const quantity = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9']

const form = reactive({
    date: null,
    customer_id: null
})

</script>


<template>
    日付<br />
    <input type='date' name='date' v-model='form.date' /><br />

    会員名<br />
    <select>
        <option v-for="customer in customers" :value='customer.id' :key='customer.id'>
            {{ customer.id }} : {{ customer.name }}
        </option>
    </select>

    <br />

    商品・サービス<br />
    <table>
        <thead>
            <th>Id</th>
            <th>商品名</th>
            <th>金額</th>
            <th>数量</th>
            <th>小計</th>
        </thead>
        <tbody>
            <tr v-for="item in itemList">
                <td>{{ item.id }}</td>
                <td>{{ item.name }}</td>
                <td>{{ item.price }}</td>
                <td>
                    <select name='quantity' v-model="item.quantity">
                        <option v-for="q in quantity" :value='q'>
                            {{ q }}
                        </option>
                    </select>
                </td>
                <td>
                    {{ item.price * item.quantity }}
                </td>
            </tr>
        </tbody>
    </table>
    <br />

    合計金額<br />
    {{ totalPrice }}円


</template>
