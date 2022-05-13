import ContextOpenClose from "./contextOpenClose.js";
import Form from './form.js';

export default class MonthSelector extends ContextOpenClose{
    constructor(box, formSelector, btn, monthSelectorBtns){
        super(btn, box);
        this.monthSelector = new Form(formSelector);
        this.monthSelectorBtns = document.querySelectorAll(monthSelectorBtns);
    }

    setMonthAndGo(event){
        this.monthSelector.form['mes'].value = event.target.value;
        this.monthSelector.sendForm(event);
    }

    addEventToBtns(){
        this.monthSelectorBtns.forEach((btn) => {
            btn.addEventListener('click', this.setMonthAndGo);
        })
    }

    bindEventsMonthSelector(){
        this.setMonthAndGo = this.setMonthAndGo.bind(this);
    }

    initMonthSelector(){
        this.initContextOpenClose();
        this.bindEventsMonthSelector();
        this.addEventToBtns();
        this.monthSelector.initForm();
    }
}