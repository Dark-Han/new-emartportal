<script setup>
</script>

<template>
  <v-container>
    <v-row>
      <v-col cols="12">
        <v-card
            class="mx-auto"
            max-width="344"
            title="Регистрация"
        >
          <v-container>
            <v-text-field
                v-model="first"
                color="primary"
                label="Имя"
                variant="underlined"
            ></v-text-field>

            <v-text-field
                v-model="last"
                color="primary"
                label="Фамилия"
                variant="underlined"
            ></v-text-field>

            <v-text-field
                v-model="password"
                color="primary"
                label="Пароль"
                variant="underlined"
            ></v-text-field>

            <v-text-field
                v-model="password"
                color="primary"
                label="Повторите пароль"
                variant="underlined"
            ></v-text-field>

          </v-container>

          <v-divider></v-divider>

          <v-card-actions>
            <v-spacer></v-spacer>

            <v-btn color="success">
              Зарегистрироваться
              <v-icon icon="mdi-chevron-right" end></v-icon>
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>


