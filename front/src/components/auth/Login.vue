<template>
  <v-container class="d-flex justify-center mb-6">
    <v-row>
      <v-col cols="12">
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
            ></v-text-field>

            <v-text-field
                v-model="form.password"
                color="primary"
                label="Пароль"
                variant="underlined"
            ></v-text-field>
          </v-container>

          <v-divider></v-divider>

          <v-card-actions>
            <v-spacer></v-spacer>

            <v-btn color="success" @click="login">
              Войти
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
import {useRouter} from "vue-router";

let router=useRouter()

let form=ref({
  email:'',
  password:''
})

async function login(){
  axios.defaults.withCredentials = true;
  axios.defaults.withXSRFToken = true;
  await axios.get('http://localhost:8080/sanctum/csrf-cookie')
  await axios.post('http://localhost:8080/login',form.value)
  router.push('/')
}

</script>