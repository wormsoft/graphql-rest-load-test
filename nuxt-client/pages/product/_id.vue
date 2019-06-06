<template>
  <div class="product">
    <div class="img-container">
      <img src="http://dungeon.su/gallery/items/56_1_1540915419.jpg">
    </div>
    <div class="product-info">
      <div class="description">
      <span>
        {{product}}
      </span>
      </div>
      <div class="variants">
        <div class="variant" v-for="variant in product.variants">
          <div class="title-holder">
            <span>{{variant.title}}</span>
          </div>
          <div class="img-holder">
            <img src="http://dungeon.su/gallery/items/56_1_1540915419.jpg">
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    name: "_id",
    data() {
      return {
        product: {

        },
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
  .product{
    display: flex;
    flex-wrap: wrap;
  }
  .img-container{
    width: 30%;
  }
  .product-info{
    width: 60%;
  }
  .variant {
    display: flex;
    width: max-content;
    height: 100px;
    margin-bottom: 15px;
    border: 1px solid white;
  }
  .variant .img-holder {

  }
  .variant .title-holder {
    width: 400px;
  }
  .variant img{
    max-height: 100%;
  }
</style>
