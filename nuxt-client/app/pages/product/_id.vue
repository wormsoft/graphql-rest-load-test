<template>
  <div class="product">
    <div class="img-container">
      <img :src="$store.state.product.product.img" style="max-width: 400px;">
    </div>
    <div class="product-info">
      <div class="description">
        <legend>Описание:</legend>
        <span>
        {{$store.state.product.product.description}}
      </span>
      </div>
      <div class="variants">
        <table class="var-table">
          <tr>
            <th>Название</th>
            <th>Цена</th>
            <th>Описание</th>
            <th></th>
          </tr>
          <tr v-for="variant in $store.state.product.product.variants">
            <td>{{variant.title}}</td>
            <td>{{variant.price}}</td>
            <td>{{variant.description}}</td>
            <td><img :src="variant.img"></td>
          </tr>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    name: '_id',
    async mounted({store, route}) {
      if (route.query.type === 'gql') {
        await this.$store.dispatch('product/GET_PRODUCT_BY_ID_GQL', this.$route.params.id)
      } else {
        await this.$store.dispatch('product/GET_PRODUCT_BY_ID_REST', this.$route.params.id)
      }
    },
  }
</script>

<style scoped>
  .product {
    display: flex;
    flex-wrap: wrap;
  }

  .img-container {
    width: 30%;
  }

  .description {
    height: 150px;
    text-align: center;
  }

  .var-table {
    border-collapse: collapse;
  }

  .product-info {
    width: 60%;
  }

  .var-table {
    border: solid 1px white;
  }

  .var-table td {
    border-top: solid 1px white;
    width: 20%;
    text-align: center;
  }

  .var-table td img {
    height: 160px;
  }
</style>
