import Page from "./page.js";

export default class NavMenu{
    constructor(ulMenu){
        this.menuBtns = document.querySelectorAll(`${ulMenu} li`);
    }

    handleClick(event){
        event.preventDefault();
        this.href = event.target.getAttribute('href');
        window.history.pushState(null, null, this.href);
        this.page = new Page();
        this.page.load(this.href);
    }

    addEvent(){
        this.menuBtns.forEach((btn) => {
            btn.addEventListener('click', this.handleClick)
        })
    }

    bindEvents(){
        this.handleClick = this.handleClick.bind(this);
    }

    initNavMenu(){
        this.bindEvents();
        this.addEvent();
    }
}