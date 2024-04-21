<template>
  <v-row>
    <v-btn
        color="success"
        @click="dialog = true">
      Добавить
    </v-btn>

    <v-dialog
        v-model="dialog"
        transition="dialog-bottom-transition"
        fullscreen
    >
      <v-card>
        <v-toolbar>
          <v-btn
              icon="mdi-close"
              @click="dialog = false"
          ></v-btn>

          <v-toolbar-title>Регистрации</v-toolbar-title>

          <v-spacer></v-spacer>

          <v-toolbar-items>
            <v-btn
                text="Сохранить"
                variant="text"
                @click="dialog = false"
            ></v-btn>
          </v-toolbar-items>
        </v-toolbar>
        <form>
          <v-container>
            <v-row>
              <v-col cols="7">
                <v-text-field
                    v-model="form.iin"
                    label="ИИН"
                    variant="underlined"
                ></v-text-field>
                <v-text-field
                    v-model="form.fullName"
                    label="ФИО"
                    variant="underlined"
                ></v-text-field>
                <v-text-field
                    v-model="form.documentNumber"
                    label="Номер документа"
                    variant="underlined"
                ></v-text-field>
                <v-text-field
                    v-model="form.documentGiven"
                    label="Документ выдан"
                    variant="underlined"
                ></v-text-field>
                <v-text-field
                    v-model="form.address"
                    label="Адресс"
                    variant="underlined"
                ></v-text-field>
                <v-text-field
                    v-model="form.clientType"
                    label="Тип клиента"
                    variant="underlined"
                ></v-text-field>
                <v-text-field
                    v-model="form.phoneNumber"
                    label="Телефон"
                    variant="underlined"
                ></v-text-field>
                <v-text-field
                    v-model="form.givenDate"
                    label="Дата выдачи"
                    variant="underlined"
                ></v-text-field>
                <v-text-field
                    v-model="form.returnDate"
                    label="Дата сдачи"
                    variant="underlined"
                ></v-text-field>
                <v-text-field
                    v-model="form.paid"
                    label="Оплачено"
                    variant="underlined"
                ></v-text-field>
                <v-text-field
                    v-model="form.duty"
                    label="Долг"
                    variant="underlined"
                ></v-text-field>
                <v-text-field
                    v-model="form.paymentType"
                    label="Тип оплаты"
                    variant="underlined"
                ></v-text-field>
                <v-text-field
                    v-model="form.consultant"
                    label="Консультант"
                    variant="underlined"
                ></v-text-field>
              </v-col>
              <v-col cols="1"></v-col>
              <v-col cols="4">
                <v-autocomplete
                    v-for="(tool,index) in form.tools"
                    v-model="tool.id"
                    item-value="id"
                    item-title="tool_type.name"
                    :items="tools"
                    label="Инструмент"
                    variant="underlined"
                ></v-autocomplete>
              </v-col>
            </v-row>
          </v-container>
        </form>
      </v-card>
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
        @dblclick:row="toggleDrawer"
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
      <template v-slot:item.actions="{ item }">
        <v-icon
            class="me-2"
            size="small"
            @click="editItem(item)"
        >
          mdi-pencil
        </v-icon>
        <v-icon
            size="small"
            @click=""
        >
          mdi-delete
        </v-icon>
      </template>
    </v-data-table-server>

    <v-navigation-drawer
        v-model="drawer"
        temporary
        location="right"
    >
      <v-list-item
          title="Транзакции"
      ></v-list-item>

      <v-divider></v-divider>

      <v-table>
        <thead>
        <tr>
          <th class="text-left">
            Тип
          </th>
          <th class="text-left">
            Оплачено
          </th>
          <th class="text-left">
            Долг
          </th>
        </tr>
        </thead>
        <tbody>
        <tr
            v-for="action in actions"
            :key="action.id"
        >
          <td>{{ action.type }}</td>
          <td>{{ action.paid }}</td>
          <td>{{ action.duty }}</td>
        </tr>
        </tbody>
      </v-table>
    </v-navigation-drawer>

  </v-row>
</template>

<script setup>

import {onMounted, reactive, ref} from "vue";
import axios from "axios";

const resource = 'registrations'

let table = reactive({
  defaultItemsPerPage: 5,
  totalCount: 0,
  loading: true,
  search: {
    id: '',
    name: ''
  },
  headers: [
    {title: 'ID', align: 'center', sortable: false, key: 'id', width: 50},
    {title: 'ID смены', key: 'id_smena', align: 'center', width: 130},
    {title: 'ФИО', key: 'fio', align: 'center'},
    {title: 'Телефон', key: 'phone', align: 'center'},
    {title: 'ИИН', key: 'iin', align: 'center'},
    {title: 'Адрес', key: 'address', align: 'center'},
    {title: 'Оплата', key: 'payment_type_id', align: 'center'},
    {title: 'Действия', key: 'actions', sortable: false},
  ]
})

let drawer = ref(false)

let dialog = ref(false)

let data = ref()
let actions = ref()

let tools = ref()

let form = reactive({
  tools: [{id: null}, {id: null}],
  iin: '',
  fullName: '',
  documentNumber: '',
  documentGiven: '',
  address: '',
  clientType: '',
  phoneNumber: '',
  givenDate: '',
  returnDate: '',
  paid: '',
  duty: '',
  paymentType: '',
  consultant: '',
})

let freshForm = {
  tools: [{id: null}, {id: null}],
  iin: '',
  fullName: '',
  documentNumber: '',
  documentGiven: '',
  address: '',
  clientType: '',
  phoneNumber: '',
  givenDate: '',
  returnDate: '',
  paid: '',
  duty: '',
  paymentType: '',
  consultant: '',
}


onMounted(() => {
  loadTools()
})

async function loadData({page, itemsPerPage, sortBy}) {
  let query = 'page=' + page + '&itemsPerPage=' + itemsPerPage + '&search=' + table.search + '&sortBy=' + sortBy
  let response = await axios.get('/api/v1/' + resource + '?' + query)
  data.value = response.data.data
  table.totalCount = response.data.total
  table.loading = false
}

async function addRow() {
  let response = await axios.post('/api/v1/tools', form)
  closeDialog()
  data.value.unshift(response.data)
  data.value.pop()
  Object.assign(form, freshForm)
}

async function loadTools() {
  let response = await axios.get('/api/v1/tools')
  tools.value = response.data.data
}

function closeDialog() {
  dialog.value = false
  Object.assign(form, freshForm)
}

async function toggleDrawer(event, selectedRow) {
  drawer.value = !drawer.value
  if (drawer.value === false) {
    return
  }
  let selectedRegistrationId = selectedRow.item.id
  loadActionsByRegistrationId(selectedRegistrationId)
}

async function loadActionsByRegistrationId(registrationId) {
  let response = await axios.get('/api/v1/' + resource + '/' + registrationId + '/actions')
  actions.value = response.data
}
</script>