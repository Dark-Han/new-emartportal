<template>
  <v-row>
    <v-btn
        color="success"
        @click="dialog = true">
      Добавить
    </v-btn>

    <v-dialog
        v-model="dialog"
        width="auto"
        class="dialog"
    >
      <v-sheet class="mx-auto" width="500">

        <form>
          <v-text-field
              v-model="toolType.name"
              label="Название"
              variant="underlined"
          ></v-text-field>

          <v-btn
              class="me-4"
              @click="addToolType"
              color="success"
          >
            Добавить
          </v-btn>
          <v-btn
              color="error"
              class="me-4"
              @click="dialog=false">
            Отмена
          </v-btn>
        </form>
      </v-sheet>
    </v-dialog>
  </v-row>
  <v-row>
    <v-data-table-server
        v-model:items-per-page="table.defaultItemsPerPage"
        :headers="table.headers"
        :items="toolsTypes"
        :items-length="table.totalCount"
        :loading="table.loading"
        :search="table.search"
        @update:options="loadToolsTypes"
    >
      <template v-slot:tfoot>
        <tr>
          <td>
            <v-text-field v-model="table.search.name" class="ma-2" density="compact" placeholder="Введите название"
                          hide-details></v-text-field>
          </td>
          <td>
            <v-text-field
                v-model="table.search.id"
                class="ma-2"
                density="compact"
                placeholder="Введите id"
                type="number"
                hide-details
            ></v-text-field>
          </td>
        </tr>
      </template>
    </v-data-table-server>
  </v-row>
</template>

<script setup>

import {reactive, ref} from "vue";
import axios from "axios";

let table = reactive({
  defaultItemsPerPage: 5,
  totalCount: 0,
  loading: true,
  search: {
    id: '',
    name: ''
  },
  headers: [
    {
      title: 'ID',
      align: 'start',
      sortable: false,
      key: 'id',
    },
    {title: 'Название', key: 'name', align: 'start'},
    {title: 'Создано', key: 'created_at', align: 'start'},
  ]
})

let dialog = ref(false)

let toolsTypes = ref()

let toolType = reactive({
  name: ''
})

let clearToolType = {
  name: ''
}


async function loadToolsTypes({page, itemsPerPage, sortBy}) {
  let query = 'page=' + page + '&itemsPerPage=' + itemsPerPage + '&search=' + table.search + '&sortBy=' + sortBy
  let response = await axios.get('/api/v1/tools-types?' + query)
  toolsTypes.value = response.data.data
  table.totalCount = response.data.total
  table.loading = false
}

async function addToolType() {
  let response = await axios.post('/api/v1/tools-types', toolType)
  dialog.value = false
  toolsTypes.value.unshift(response.data)
  Object.assign(toolType, clearToolType)
}

</script>