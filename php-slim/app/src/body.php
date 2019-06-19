query {
  productModule {
    catalog(query:  {search: "",  page:  "1"}) {
      totalCount
      products {
        id
        articul
        title
        price
        discount
        description
        status
        isActive
        isNew
        isPopular
        created_at
        updated_at
        img
        variants {
          id
          articul
          product_id
          title
          price
          discount
          description
          status
          isActive
          isNew
          isPopular
          created_at
          updated_at
          img
        }
      }
    }
  }
}Array