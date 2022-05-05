export default class Page{
    constructor(pageName, target){
        this.pageName = pageName;
        this.target = document.querySelector(target)
    }

    async fetchPage(){
        const response = await fetch(`/${this.pageName}.php`);
        const page = await response.text();
        return page;    
    }

    async load(){
        this.target.innerHTML = await this.fetchPage();
    }
}