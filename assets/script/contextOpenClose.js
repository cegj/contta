export default class ContextOpenClose{
    constructor(btn, box){
        this.btn = document.querySelector(btn);
        this.box = document.querySelector(box);
    }

    openClose(customBtn, customBox) {
        const btn = document.querySelector(customBtn) || this.btn;
        const box = document.querySelector(customBox) || this.box;

        btn.classList.toggle('botao-sair');
        box.classList.toggle('show');
        box.classList.toggle('hide');
        box.addEventListener('animationend', function() {
          if (box.classList.contains('hide')) {
            box.style.display = "none";
          } else {
            box.style.display = "block";
          }
        });
      }

    addEvent(){
      this.btn.addEventListener('click', () => this.openClose());     
    }

    bindEventsContextOpenClose(){
      this.addEvent = this.addEvent.bind(this);
      this.openClose = this.openClose.bind(this);
    }

    initContextOpenClose(){
      this.bindEventsContextOpenClose();
      this.addEvent();
    }

}