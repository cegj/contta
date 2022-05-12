import Page from "./page.js";

export default class Link{
    constructor(){
        this.hrefs = Array.from(document.querySelectorAll('[href]'));
        console.log(this.hrefs)


        this.hrefs.forEach((href, i) => {
            const hrefValue = href.getAttribute('href'); 
            if (hrefValue.includes('#')){
                console.log(i)
                this.hrefs.splice(i, 1)
            }
        })

        console.log(this.hrefs)
    }

    handleClick(event){
        event.preventDefault();
        const href = event.target.getAttribute('href');
        window.history.pushState(null, null, href);
        this.page = new Page();
        this.page.load(href);
    }

    addEvent(){
        this.hrefs.forEach((href) => {
            href.addEventListener('click', this.handleClick)
        })
    }

    bindEvents(){
        this.handleClick = this.handleClick.bind(this);
    }

    initLink(){
        this.bindEvents();
        this.addEvent();
    }
}