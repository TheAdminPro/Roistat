class Form {
  constructor(selector){
    this.form = document.querySelector(selector); 
  }

  onSubmitEvent(callback){
    this.form.addEventListener('submit', (e) => {
      e.preventDefault();
      const dataFields = this.getValueFields();
      callback(dataFields);
    });
  }
  // Get Value From Form's Input
  getValueFields(){
    const fields = this.form.querySelectorAll('.app-form__control');

    return [...fields].reduce((acc, field) => {
      acc[field.dataset.type] = field.value.trim();
      return acc;
    }, {});
  }
}

export default Form;