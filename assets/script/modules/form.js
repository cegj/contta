import Page from "./page.js";
import Message from "./message.js";

export default class Form{
    constructor(formSelector, msgs){
        this.form = document.querySelector(formSelector);
        this.formPath = '/app/pages/modules/' + this.form.id + '.php';
        this.formHandlerPath = '/app/form_handler/handle_' + this.form.id + '.php';
        if (msgs) this.msgs = msgs;
    }


    showMsg(type){

        if (type === 'success'){
            const msg = new Message(this.msgs.s);
            msg.show(true, 10000);
        } else if (type === 'error') {
            const msg = new Message(this.msgs.e);
            msg.show(true, 10000);
        };
    };

    removeQueryParam(queryString, params){
        const query = new URLSearchParams(queryString);

        params.forEach((param) => {
            if (query.has(param)){
                query.delete(param)
            }
        });

        return '?' + query.toString();    
    }

    async formSent(response){

        const url = this.removeQueryParam(window.location.search, ['id_conta', 'id_cat', 'id_transacao']);
        const page = new Page();
        await page.load(url, '#main-content');
        if(this.msgs){
            if (response.ok){
                this.showMsg('success');
            } else {
                this.showMsg('error');
            }
        }
    }

    sendForm(event){
        event.preventDefault();
        const fields = this.form.querySelectorAll("[name]");
        const data = new FormData();

        fields.forEach((field) => {
            if(field.type === "checkbox" || field.type === "radio"){
                if(field.checked){
                    data.append(field.name, field.value);
                }
            } else {
                data.append(field.name, field.value);
            }
        })

        fetch(this.formHandlerPath, {
            method: 'POST',
            body: data
        }).then(this.formSent);
    }

    addEvent(){
        this.form.addEventListener('submit', this.sendForm);
    }

    bindEvents(){
        this.sendForm = this.sendForm.bind(this);
        this.formSent = this.formSent.bind(this);
    }

    initForm(){
        this.bindEvents();
        this.addEvent();
    }
}