import runMainScript from "../main.js";

export default class Page{

    async fetchPage(paramString){
        const response = await fetch(`/app/pages/get_page.php/${paramString}`);
        const page = await response.text();
        return page;    
    }

    // setMessage(customContainerSelector){
    //     const modalContainer = customContainerSelector ? document.querySelector(customContainerSelector) : document.querySelector('.msg-content');
    //     modalContainer.innerHTML = '<p>Carregando...</p>';
    //     modalContainer.classList.toggle('active');
    // }

    showMessage(msg, closeBtn){
        if (msg === false) {
            document.querySelector('[data-msg]').remove();
        } else {

            const msgElement = document.createElement('span');
            msgElement.dataset.msg = "";
            
            let msgContent = "";

            msgContent += `<p>${msg}</p>`;
            if (closeBtn) msgContent += `<button class="msg-close-btn">X</button>`

            msgElement.innerHTML = msgContent;

            if (closeBtn) {
                const closeMsgBtn = msgElement.querySelector('.msg-close-btn')
                closeMsgBtn.addEventListener('click', () => {
                    msgElement.remove();
                })
            };
            
            const header = document.querySelector('body');
            header.after(msgElement);
        }
    }


    setBrowserPrevNext(){
        window.addEventListener('popstate', () => {
            this.load(window.location.search);
          });          
    }

    setPtPageName(pageName){
        switch(pageName){
            case 'board':
                this.ptPageName = '| Painel';
                break;
            case 'statement':
                this.ptPageName = '| Extrato';
                break;        
            case 'budget':
                this.ptPageName = '| Orçamento';
                break;
            case 'category':
                this.ptPageName = '| Categorias';
                break;
            case 'account':
                this.ptPageName = '| Contas';
                break;
            default:
                this.ptPageName = "";
        }
        return this.ptPageName;
    }

    async load(customParamString, customTarget){
        const paramString = (customParamString !== "") ? customParamString : '?p=board';
        const params = new URLSearchParams(paramString);
        const pageName = params.get('p');
        const target = customTarget ? document.querySelector(customTarget) : document.querySelector('#main-content');

        this.showMessage('Carregando...', false);
        target.innerHTML = await this.fetchPage(paramString);
        document.title = "Contta " + this.setPtPageName(pageName);
        runMainScript();
        this.showMessage(false);
        return this;
    }
}