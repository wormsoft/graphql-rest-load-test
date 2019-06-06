<template>
  <ol>
    <li v-for="item in getItems()">
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
    data() {
      return {
        items: this.getItems()
      }
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
