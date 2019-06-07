<template>
  <div class="product">
    <nuxt-link :to="{name:'product-id', params:{id:id}, query: $route.query}">
      <img :src="img">
      <div class="product-info">
        <span class="title">{{title}}</span>
        <br>
        <span class="price">{{price}} руб</span>
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
    width: 25%;
    text-align: center;
    font-size: 18px;
    padding: 10px;
  }

  .product img {
    height: 200px;
    width: 200px;
  }

  .product-info {
    text-align: center;
    color: white;
    text-decoration: none;
  }
  .catalog a {
    text-decoration: none ;
  }
</style>
