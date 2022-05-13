import Page from './page.js';

export default class Form{
    constructor(formSelector, msgs){
        this.form = document.querySelector(formSelector);
        this.formPath = '/app/pages/modules/' + this.form.id + '.php';
        this.formHandlerPath = '/app/form_handler/handle_' + this.form.id + '.php';
        if (msgs) this.msgs = msgs;
    }

    createMsgElement(msg){
        const msgElement = document.createElement('span');
        msgElement.innerHTML = `
        <span data-msg class="msg success">
            <p>${msg}</p>
            <button class="msg-close-btn">X</button>
        </span>
        `

        const closeMsgBtn = msgElement.querySelector('.msg-close-btn')
        closeMsgBtn.addEventListener('click', () => {
            msgElement.remove();
        })
        
        return msgElement;
    }

    showMsg(type){
        let msg;

        if (type === 'success'){
            msg = this.createMsgElement(this.msgs.s);
        } else if (type === 'error') {
            msg = this.createMsgElement(this.msgs.e);
        }

        const header = document.querySelector('#header');
        header.after(msg);
    }

    async formSent(response){

        const page = new Page();
        await page.load(window.location.search, '#main-content');
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
        console.log('Disparou')

        const fields = this.form.querySelectorAll("[name]");
        const data = new FormData();

        fields.forEach((field) => {
            data.append(field.name, field.value);
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