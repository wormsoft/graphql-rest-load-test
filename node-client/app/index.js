require('dotenv').config()

let axios = require('axios')
var express = require('express')
var app = express()
const API_HOST = process.env.SITE_API_HOST || 'https://api.test-case.s4.obvu.ru'

app.get('/listRest', async function (req, res) {
  let data = await axios.get(API_HOST + '/product-list')
  res.send(data.data)
})

app.get('/listGQL', async function (req, res) {
  let data = await axios.get(API_HOST + '/graphql')
  res.send(data.data)
})

app.get('/productRest', async function (req, res) {
  let data = await axios.post(API_HOST + '/product', {id: req.query.id ? req.query.id : 1})
  if (data.data) {
    let variants = await axios.post(API_HOST + '/variants', {productId: req.query.id ? req.query.id : 1})
    data.data.variants = variants.data
  }
  res.send(data.data)
})

app.get('/productGQL', async function (req, res) {
  let data = await axios.get(API_HOST + '/graphql?to=product', {id: 2})
  res.send(data.data)
})

app.listen(3000, function () {
  console.log('Example app listening on port 3000!')
})
