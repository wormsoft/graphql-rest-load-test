<template>
  <div>
    <div>
      <legend>GQL</legend>
      <span>{{productGQL}}</span>
    </div>
    <div>
      <legend>REST</legend>
      <span>{{productREST}}</span>
    </div>
  </div>

</template>

<script>
  export default {
    name: "_id",
    data() {
      return {
        productGQL: null,
        productREST: null,
      }
    },
    methods: {
      getProductGQL(id) {
        this.$store.dispatch('product/GET_PRODUCT_BY_ID_GQL', id).then((data) => {
          this.productGQL = data
        })
      },
      getProductREST(id) {
        this.$store.dispatch('product/GET_PRODUCT_BY_ID_REST', id).then((data) => {
          this.productREST = data
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
