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

        <form @submit.prevent>
          <v-text-field
              v-model="form.name"
              label="Название"
              variant="underlined"
              :error-messages="validationErrors.name"
          ></v-text-field>

          <v-btn
              class="me-4"
              @click="addRow"
              color="success"
          >
            Добавить
          </v-btn>
          <v-btn
              color="error"
              class="me-4"
              @click="hideCancelWindow()">
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
        :items="data"
        :items-length="table.totalCount"
        :loading="table.loading"
        :search="table.search"
        @update:options="loadData"
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

let validationErrors = ref({})

let table = reactive({
  defaultItemsPerPage: 5,
  totalCount: 0,
  loading: true,
  search: {
    id: '',
    name: ''
  },
  headers: [
    {title: 'ID', align: 'start', sortable: false, key: 'id'},
    {title: 'Название', key: 'name', align: 'start'},
    {title: 'Создано', key: 'created_at', align: 'start'},
  ]
})

let dialog = ref(false)

let data = ref()

let form = reactive({
  name: ''
})

let freshForm = {
  name: ''
}


async function loadData({page, itemsPerPage, sortBy}) {
  let query = 'page=' + page + '&itemsPerPage=' + itemsPerPage + '&search=' + table.search + '&sortBy=' + sortBy
  let response = await axios.get('/api/v1/tools-types?' + query)
  data.value = response.data.data
  table.totalCount = response.data.total
  table.loading = false
}

async function addRow() {
  validationErrors.value = {}
  try {
    let response = await axios.post('/api/v1/tools-types', form)
    dialog.value = false
    data.value.unshift(response.data)
    Object.assign(form, freshForm)
  } catch (error) {
    if (error.response.status === 422) {
      validationErrors.value = error.response.data.errors
    }
  }

}

function hideCancelWindow() {
  dialog.value = false
  validationErrors.value = {}
}

</script>