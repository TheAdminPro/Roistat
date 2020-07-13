import { baseURL } from './config.js'

class Request{
  static async sendRequest(config = {}){
    const response = await fetch(baseURL + config.module, this.constructOption(config));
    console.log(response);
    return await response.ok ? response.json() : false;
  }

  static constructOption(config){
    const option = {};
    option.method = config.method || "GET";
    if(option.method !== "GET"){
      option.body = JSON.stringify(config.data || {})
    }
    option.headers = config.headers || {
      'Content-Type': 'application/json'
    }
    console.log(option);
    return option;
  }
}

export default Request;