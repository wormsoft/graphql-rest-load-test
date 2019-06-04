let api_config = {
  api_url: 'http://localhost:3000',
}

function setApiToken(token) {
  api_config.api_token = token
  localStorage.setItem('token', token)
  return token
}

function getApiToken() {
  return api_config.api_token
}

export {api_config, setApiToken, getApiToken}
