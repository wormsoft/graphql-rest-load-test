<template>
  <div class="catalog">
    <div class="filters">
      <CatalogFilters/>
    </div>
    <div class="product-list">
      <ProductComponent
        v-for="product in $store.state.product.catalog.products"
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
    async asyncData({store, route}) {
      if (route.query.type === 'gql') {
        await store.dispatch('product/GET_PRODUCT_LIST_BY_QUERY_GQL', {
          search: route.query.search,
          page: route.query.page,
        })
      } else {
        await store.dispatch('product/GET_PRODUCT_LIST_BY_QUERY_REST', {
          search: route.query.search,
          page: route.query.page,
        })
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
