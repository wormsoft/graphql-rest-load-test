import getProduct from '~/graphql/query/getProduct.graphql'
import getProductList from '~/graphql/query/getProductList.graphql'
import api from '../../config/api/client'

export const state = () => ({})
export const actions = {
  async GET_PRODUCT_BY_ID_GQL(context, productId) {
    let data = await this.app.apolloProvider.defaultClient.query({
      query: getProduct,
      variables: {
        productId: productId
      }
    })
    return data.data.productModule.singleProduct
  },
  async GET_PRODUCT_LIST_BY_QUERY_GQL(context, query) {
    let data = await this.app.apolloProvider.defaultClient.query({
      query: getProductList,
      variables: {
        query: query
      }
    })
    return data.data.productModule.productList
  },
  async GET_PRODUCT_BY_ID_REST(context, productId) {
    let data = await api.post('api/product', {id: productId})
    return data.data
  },
  async GET_PRODUCT_LIST_BY_QUERY_REST(context, query) {
    let data = await api.post('api/product-list', {query: query})
    return data.data
  },
}
