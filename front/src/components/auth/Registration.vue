<script setup>
</script>

<template>
  <v-container class="d-flex justify-center mb-6">
    <v-row>
      <v-col cols="12">
        <v-card
            class="mx-auto"
            max-width="344"
            title="Регистрация"
        >
          <v-container>
            <v-text-field
                v-model="form.name"
                color="primary"
                label="ФИО"
                variant="underlined"
                :error-messages="validationErrors.name"
            ></v-text-field>

            <v-text-field
                v-model="form.email"
                color="primary"
                label="Email"
                variant="underlined"
                :error-messages="validationErrors.email"
            ></v-text-field>

            <v-text-field
                v-model="form.password"
                color="primary"
                label="Пароль"
                variant="underlined"
                :error-messages="validationErrors.password"
            ></v-text-field>

            <v-text-field
                v-model="form.password_confirmation"
                color="primary"
                label="Повторите пароль"
                variant="underlined"
                :error-messages="validationErrors.password_confirmation"
            ></v-text-field>

          </v-container>

          <v-divider></v-divider>

          <v-card-actions>
            <v-spacer></v-spacer>

            <v-btn color="success" @click="register">
              Зарегистрироваться
              <v-icon icon="mdi-chevron-right" end></v-icon>
            </v-btn>

          </v-card-actions>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script setup>

import {ref} from "vue";
import axios from "axios";

let validationErrors = ref({})

let form = ref({
  name: '',
  email: '',
  password: '',
  password_confirmation: ''
})

async function register() {
  validationErrors.value = {}
  try {
    await axios.get('sanctum/csrf-cookie')
    await axios.post('register', form.value)
  } catch (error) {
    if (error.response.status === 422) {
      validationErrors.value = error.response.data.errors
    }
  }
}

</script>

