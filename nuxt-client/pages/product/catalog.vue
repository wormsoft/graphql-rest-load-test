<template>
  <div>
    <div class="product-list">
      <ProductComponent
        v-for="product in products"
        :title="product.title" :price="product.price" :id="Number(product.id)" img="dfdff"/>
    </div>
  </div>
</template>

<script>
  import ProductComponent from "../../components/product/ProductComponent";

  export default {
    name: "catalog",
    components: {ProductComponent},
    data() {
      return {
        products: null,
      }
    },
    methods: {
      getProductGQL() {
        this.$store.dispatch('product/GET_PRODUCT_LIST_BY_QUERY_GQL', this.getData()).then((data) => {
          this.products = data.products
        })
      },
      getProductREST() {
        this.$store.dispatch('product/GET_PRODUCT_LIST_BY_QUERY_REST', this.getData()).then((data) => {
          this.products = data.products
        })
      },
      getData() {
        return {
          search: this.$route.query.search,
          page: this.$route.query.page,
        }
      }
    },
    mounted() {
      if (this.$route.query.type === 'gql') {
        this.getProductGQL()
      } else {
        this.getProductREST()
      }
    }
  }
</script>

<style scoped>
  .product-list {
    display: flex;
    flex-wrap: wrap;
  }
</style>
