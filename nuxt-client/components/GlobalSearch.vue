<template>
  <v-form>
    <v-container>
      <v-layout>
        <v-flex xs12 md12>
          <v-text-field v-model="searchQuery" label="Поиск"></v-text-field>
          <button class="header-main__button" @click.enter.prevent="getSearch"></button>
        </v-flex>
      </v-layout>
    </v-container>
  </v-form>
</template>

<script>
  export default {
    name: "GlobalSearch",
    data() {
      return {
        searchQuery: null
      }
    },
    methods: {
      getSearch() {
        this.$router.push({name: "product-catalog", query: {search: this.searchQuery}})
      }
    }
  }

</script>

<style scoped>

</style>
