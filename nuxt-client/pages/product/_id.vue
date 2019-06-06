<template>
  <div>
    <div>
      <legend>PRODUCT</legend>
      <span>{{product}}</span>
    </div>
  </div>

</template>

<script>
  export default {
    name: "_id",
    data() {
      return {
        product: null,
      }
    },
    methods: {
      getProductGQL(id) {
        this.$store.dispatch('product/GET_PRODUCT_BY_ID_GQL', id).then((data) => {
          this.product = data
        })
      },
      getProductREST(id) {
        this.$store.dispatch('product/GET_PRODUCT_BY_ID_REST', id).then((data) => {
          this.product = data
        })
      },
    },
    mounted() {
      if (this.$route.query.type === 'gql') {
        this.getProductGQL(this.$route.params.id)
      } else {
        this.getProductREST(this.$route.params.id)
      }
    }
  }
</script>

<style scoped>

</style>
