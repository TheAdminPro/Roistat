import Form from './FormApi.js';
import Request from './RequestApi.js';

const loaded = () => {
  const main = document.querySelector('.main');
  const form = new Form('.app-form');

  form.onSubmitEvent(async (dataFields) => {
    main.classList.add('sending');

    const { data } = await Request.sendRequest({
      module: 'create-lead',
      method: 'POST',
      data: dataFields
    });

    console.log(data);
    main.classList.remove('sending');
    // Show Response From Server 
    showResponseServer(data);
  });
}


function showResponseServer(data){
  const resData = Object.assign(data[0]);
  const responseView = document.querySelector('.response-server');
  const responseContent = responseView.querySelector('.response-server__content');
  const responseMsg = responseView.querySelector('.response-server__message');
  responseMsg.textContent = resData.message;
  responseContent.classList.add(resData.status);
  responseView.classList.add('show');
  setTimeout(()=>{
    responseView.classList.remove('show');
  }, 1000);
}

document.addEventListener('DOMContentLoaded', loaded);