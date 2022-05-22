export default class Message{
    constructor(msg){
        this.msg = msg;
        this.element = document.createElement('span');
    }

    show(closeBtn, timeOut){

            this.element.dataset.msg = "";
            
            let msgContent = "";

            msgContent += `<p>${this.msg}</p>`;
            if (closeBtn) msgContent += `<button class="msg-close-btn">X</button>`

            this.element.innerHTML = msgContent;

            if (closeBtn) {
                const closeMsgBtn = this.element.querySelector('.msg-close-btn')
                closeMsgBtn.addEventListener('click', () => {
                    this.element.remove();
                })
            };
            
            document.querySelector('#msg-placeholder').appendChild(this.element);

            this.close = this.close.bind(this);
            if (timeOut){
                setTimeout(this.close, timeOut);
            }
        }

    close(){
        this.element.remove();
    }
    }