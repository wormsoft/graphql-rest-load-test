<template>
  <ol>
    <li v-for="item in this.getItems()">
      <span>{{item}}</span>
    </li>
  </ol>

</template>

<script>
  export default {
    name: "CatalogFilters",
    props: {
      items: {
        type: Array,
      },
    },
    methods: {
      getItems() {
        let arr = []
        for (let i = 0; i < 15; i++) {
          arr.push('Пункт')
        }
        return arr
      }
    }
  }
</script>

<style scoped>

</style>
