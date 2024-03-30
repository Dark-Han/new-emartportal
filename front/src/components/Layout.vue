<template>
  <v-layout class="rounded rounded-md">
    <v-app-bar title="Emartportal"></v-app-bar>

    <v-navigation-drawer>
      <v-list-item to="/registrations">
        <v-list-item-content>Регистрации</v-list-item-content>
      </v-list-item>
      <v-list-item to="/tools">
        <v-list-item-content>Инструменты</v-list-item-content>
      </v-list-item>
      <v-list-item to="/tools-types">
        <v-list-item-content>Типы инструментов</v-list-item-content>
      </v-list-item>
    </v-navigation-drawer>

    <v-main>
      <v-container>
        <router-view></router-view>
      </v-container>
    </v-main>
  </v-layout>
</template>

<script setup>

</script>