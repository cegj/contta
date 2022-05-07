export default class ShowHide{
    constructor(trigger, classToHide){
        this.trigger = document.querySelector(trigger);
        this.classToHide = document.querySelectorAll(classToHide);
    }

    show(customClass){

        let elements = customClass ? document.querySelector(customClass) : this.classToHide;

        elements.forEach((element) => {
            element.style.opacity = 1;
        })
    }

        hide(customClass){

            let elements = customClass ? document.querySelector(customClass) : this.classToHide;
    
            elements.forEach((element) => {
                element.style.opacity = 0;
            })
    }

    handleTrigger(){
        if (this.trigger.classList.contains('active')){
            this.hide();
            this.trigger.classList.remove('active');
            localStorage.setItem('hideMoney', "true");
        } else {
            this.show();
            this.trigger.classList.add('active');
            localStorage.setItem('hideMoney', "false");
        }
    }

    addEvent(){
        this.trigger.addEventListener('click', this.handleTrigger)
    }

    setOnInit(){
        if (localStorage.hideMoney === 'false'){
            this.show();
            this.trigger.classList.add('active');
        }
    }

    bindEvents(){
        this.handleTrigger = this.handleTrigger.bind(this);
    }

    initShowHide(){
        this.bindEvents();
        this.setOnInit();
        this.addEvent();
    }
}