import getProduct from '~/graphql/query/getProduct.graphql'
import getProductList from '~/graphql/query/getProductList.graphql'
import api from '../../config/api/client'

export const state = () => {
  return {
    product: {
      
    },
    catalog: [],
  }
}
export const mutations = {
  setProduct(state, payload) {
    state.product = payload
  },
  setCatalog(state, payload) {
    state.catalog = payload
  }
}
export const actions = {
  async GET_PRODUCT_BY_ID_GQL({ commit }, productId) {
    let data = await this.app.apolloProvider.defaultClient.query({
      query: getProduct,
      variables: {
        productId: productId
      }
    })
    commit('setProduct', data.data.productModule.singleProduct)
    return data.data.productModule.singleProduct
  },
  async GET_PRODUCT_LIST_BY_QUERY_GQL({ commit }, query) {
    console.log(query)
    let data = await this.app.apolloProvider.defaultClient.query({
      query: getProductList,
      variables: {
        query: query
      }
    })
    commit('setCatalog', data.data.productModule.catalog)
    return data.data.productModule.catalog
  },
  async GET_PRODUCT_BY_ID_REST({ commit }, productId) {
    let data = await api.post('product', {id: productId})
    commit('setProduct', data.data)
    return data.data
  },
  async GET_PRODUCT_LIST_BY_QUERY_REST({ commit }, query) {
    let data = await api.post('product-list', {query: query})
    commit('setCatalog', data.data)
    return data.data
  },
}
