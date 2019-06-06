<template>
  <div class="product">
    <nuxt-link :to="{name:'product-id', params:{id:id}, query: $route.query}">
      <img src="http://dungeon.su/gallery/items/56_1_1540915419.jpg">
      <div class="product-info">
        <span class="title">{{title}}</span>
        <br>
        <span class="price">{{price}}</span>
      </div>
    </nuxt-link>
  </div>
</template>

<script>
  export default {
    name: "ProductComponent",
    props: {
      img: {
        type: String,
        required: true
      },
      title: {
        type: String,
        required: true
      },
      price: {
        type: Number,
        required: true
      },
      id: {
        type: Number,
        required: true
      }
    },
  }
</script>

<style scoped>
  .product {
    display: flex;
    flex-direction: column;
    flex-wrap: wrap;
    max-width: 275px;
    text-align: center;
    font-size: 18px;
    padding: 10px;
  }

  .product img {
    max-height: 300px;
  }

  .product-info {
    text-align: center;
    color: white;
    text-decoration: none;
  }
</style>
