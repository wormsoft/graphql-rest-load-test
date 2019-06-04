import axios from 'axios'
import {api_config} from '../../api_config'

function request (method, url, params, data, token) {
  let axios_config = {
    // `baseURL` is the server URL that will be used for the request
    baseURL: api_config.api_url,

    // `method` is the request method to be used when making the request
    method: method,

    // `url` will be prepended to `baseURL` unless `baseURL` is absolute.
    url: url,

    headers: {
      Authorization: 'Bearer ' + token
    }
  }

  if (params) {
    // `params` are the URL parameters to be sent with the request
    axios_config.params = params
  }

  if (data) {
    // `data` allows changes to the request data before it is sent to the server
    // This is only applicable for request methods 'PUT', 'POST', and 'PATCH'
    axios_config.data = data
  }

  if (token) {
    axios_config.headers = {
      Authorization: 'Bearer ' + token
    }
  }

  return axios(axios_config)
}

function get (url, token) {
  return request('get', url, null, null, token)
}

function post (url, data, token) {
  data = data || {}
  return request('post', url, null, data, token)
}

function put (url, data, token) {
  data = data || {}
  return request('put', url, null, data, token)
}

function remove (url, token) {
  return request('delete', url, null, null, token)
}

export default {get, post, put, remove, request}
