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
            ></v-text-field>

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

            <v-text-field
                v-model="form.password_confirmation"
                color="primary"
                label="Повторите пароль"
                variant="underlined"
            ></v-text-field>

          </v-container>

          <v-divider></v-divider>

          <v-card-actions>
            <v-spacer></v-spacer>

            <v-btn color="success" @click="register">
              Зарегистрироваться
              <v-icon icon="mdi-chevron-right" end></v-icon>
            </v-btn>

            <v-btn color="success" @click="test">
              testing
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

let form=ref({
  name:'',
  email:'',
  password:'',
  password_confirmation:''
})

async function register(){
  axios.defaults.withCredentials = true;
  axios.defaults.withXSRFToken = true;
  await axios.get('http://localhost:8080/sanctum/csrf-cookie')
  await axios.post('http://localhost:8080/register',form.value)
}

async function test(){
  axios.defaults.withCredentials = true;
  axios.defaults.withXSRFToken = true;
  await axios.post('http://localhost:8080/api/user123',{test:'data'})
}

</script>

