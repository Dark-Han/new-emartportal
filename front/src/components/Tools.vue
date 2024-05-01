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
          <v-autocomplete
              v-model="form.tool_type_id"
              item-value="id"
              item-title="name"
              :items="toolTypes"
              label="Инструмент"
              variant="underlined"
              :error-messages="validationErrors.tool_type_id"
          ></v-autocomplete>

          <v-text-field
              v-model="form.serial_number"
              label="Серийный номер"
              variant="underlined"
              :error-messages="validationErrors.serial_number"
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
              @click="closeDialog">
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

import {onMounted, reactive, ref} from "vue";
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
    {title: 'ID', align: 'center', sortable: false, key: 'id'},
    {title: 'Инструмент', key: 'tool_type.name', align: 'center'},
    {title: 'Серийный номер', key: 'serial_number', align: 'center'},
    {title: 'Создано', key: 'created_at', align: 'center'},
  ]
})

let dialog = ref(false)

let data = ref()

let toolTypes = ref()

let form = reactive({
  tool_type_id: null,
  serial_number: '',
})

let freshForm = {
  tool_type_id: null,
  serial_number: '',
}


onMounted(() => {
  loadToolTypes()
})

async function loadData({page, itemsPerPage, sortBy}) {
  let query = 'page=' + page + '&itemsPerPage=' + itemsPerPage + '&search=' + table.search + '&sortBy=' + sortBy
  let response = await axios.get('/api/v1/tools?' + query)
  data.value = response.data.data
  table.totalCount = response.data.total
  table.loading = false
}

async function addRow() {
  validationErrors.value = {}
  try {
    let response = await axios.post('/api/v1/tools', form)
    data.value.unshift(response.data)
    closeDialog()
  } catch (error) {
    if (error.response.status === 422) {
      validationErrors.value = error.response.data.errors
    }
  }

}

async function loadToolTypes() {
  let response = await axios.get('/api/v1/tools-types')
  toolTypes.value = response.data.data
}

function closeDialog() {
  dialog.value = false
  Object.assign(form, freshForm)
  validationErrors.value = {}
}
</script>