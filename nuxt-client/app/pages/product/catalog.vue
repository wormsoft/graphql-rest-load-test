<template>
  <div class="catalog">
    <div class="filters">
      <CatalogFilters/>
    </div>
    <div class="product-list">
      <ProductComponent
        v-for="product in products"
        :title="product.title"
        :price="product.price"
        :id="Number(product.id)"
        :img="product.img"/>
    </div>
  </div>
</template>

<script>
  import ProductComponent from "../../components/product/ProductComponent";
  import CatalogFilters from "../../components/product/CatalogFilters";

  export default {
    name: "catalog",
    components: {ProductComponent, CatalogFilters},
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
    watch: {
      $route() {
        if (this.$route.query.type === 'gql') {
          this.getProductGQL()
        } else {
          this.getProductREST()
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
  .catalog {
    display: flex;
    flex-wrap: wrap;
  }

  .product-list {
    display: flex;
    flex-wrap: wrap;
    width: 75%;
  }

  .filters {
    display: flex;
    flex-wrap: wrap;
    width: 20%;
    margin: 15px;
  }

</style>
