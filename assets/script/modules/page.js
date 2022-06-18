import runMainScript from "../main.js";
import Message from "./message.js";

export default class Page {

    async fetchPage(paramString) {
        const response = await fetch(`/app/pages/get_page.php/${paramString}`);
        const page = await response.text();
        return page;
    }

    setBrowserPrevNext() {
        window.addEventListener('popstate', () => {
            this.load(window.location.search);
        });
    }

    setPageName() {
        this.ptPageName = document.querySelector('main').dataset.pageName;

        if (this.ptPageName) {
            return "| " + this.ptPageName;
        } else {
            return "";
        }
    }

    async load(customParamString, customTarget) {
        const paramString = (customParamString !== "") ? customParamString : '?p=board';
        const params = new URLSearchParams(paramString);
        const pageName = params.get('p');
        const target = customTarget ? document.querySelector(customTarget) : document.querySelector('#main-content');

        const loadingMsg = new Message('Carregando...');
        loadingMsg.show();
        target.innerHTML = await this.fetchPage(paramString);
        document.title = "Contta " + this.setPageName();
        runMainScript();
        loadingMsg.close();
        return this;
    }
}