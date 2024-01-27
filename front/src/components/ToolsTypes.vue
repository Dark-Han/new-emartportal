<template>
  <v-table
      fixed-header
      height="300px"
  >
    <thead>
    <tr>
      <th class="text-left">
        Название
      </th>
      <th class="text-left">
        Создано
      </th>
    </tr>
    </thead>
    <tbody>
    <tr
        v-for="type in toolsTypes"
        :key="type.id"
    >
      <td>{{ type.name }}</td>
      <td>{{ type.created_at }}</td>
    </tr>
    </tbody>
  </v-table>
</template>

<script setup>

import {onMounted, ref} from "vue";
import axios from "axios";

let toolsTypes = ref()


onMounted(() => {
  loadToolsTypes()
})

async function loadToolsTypes() {
  let response = await axios.get('/api/v1/tools-types')
  toolsTypes.value = response.data
}

</script>