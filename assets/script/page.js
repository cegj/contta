export default class Page{
    constructor(pageName, target){
        this.pageName = pageName;
        this.target = document.querySelector(target)
    }

    async fetchPage(){
        const response = await fetch(`/app/pages/${this.pageName}.php`);
        const page = await response.text();
        return page;    
    }

    setPtPageName(pageName){
        switch(pageName){
            case 'board':
                this.ptPageName = 'Painel';
                break;
            case 'statement':
                this.ptPageName = 'Extrato';
                break;        
            case 'budget':
                this.ptPageName = 'Orçamento';
                break;
            case 'category':
                this.ptPageName = 'Categorias';
                break;
            case 'account':
                this.ptPageName = 'Contas';
                break;
        }
        return this.ptPageName;
    }

    async load(){
        this.target.innerHTML = await this.fetchPage();
        document.title = "Contta / " + this.setPtPageName(this.pageName);
    }
}