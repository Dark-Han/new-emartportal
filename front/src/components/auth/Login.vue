<template>
  <v-container class="d-flex justify-center mb-6">
    <v-row>
      <v-col cols="12">
        <v-form
            @submit.prevent>
          <v-card
              class="mx-auto"
              max-width="344"
              title="Вход в систему"
          >
            <v-container>
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
            </v-container>

            <v-divider></v-divider>

            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="success" type="submit" @click="login">
                Войти
                <v-icon icon="mdi-chevron-right" end></v-icon>
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-form>
      </v-col>
    </v-row>
  </v-container>
</template>

<script setup>

import {ref} from "vue";
import axios from "axios";
import {useRouter} from "vue-router";

let validationErrors = ref({})

let router = useRouter()

let form = ref({
  email: '',
  password: ''
})

async function login() {
  resetValidationErrors()
  try {
    await axios.get('sanctum/csrf-cookie')
    await axios.post('login', form.value)
    await router.push('/')
  } catch (error) {
    if (error.response.status === 422) {
      validationErrors.value = error.response.data.errors
    }
  }
}

function resetValidationErrors() {
  validationErrors.value = {}
}
</script>