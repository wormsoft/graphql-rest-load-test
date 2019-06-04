<template>
  <div>
    <div>
      <legend>GQL</legend>
      <span>{{productsGQL}}</span>
    </div>
    <div>
      <legend>REST</legend>
      <span>{{productsREST}}</span>
    </div>
  </div>

</template>

<script>
  export default {
    name: "catalog",
    data() {
      return {
        productsGQL: null,
        productsREST: null,
      }
    },
    methods: {
      getProductGQL(query) {
        this.$store.dispatch('product/GET_PRODUCT_LIST_BY_QUERY_GQL', query).then((data) => {
          this.productsGQL = data
        })
      },
      getProductREST(query) {
        this.$store.dispatch('product/GET_PRODUCT_LIST_BY_QUERY_REST', query).then((data) => {
          this.productsREST = data
        })
      },
    },
    mounted() {
      this.getProductGQL(this.$route.params.id)
      this.getProductREST(this.$route.params.id)
    }
  }
</script>

<style scoped>

</style>
