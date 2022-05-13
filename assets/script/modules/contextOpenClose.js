export default class ContextOpenClose{
    constructor(btn, box){
        this.btn = document.querySelector(btn);
        this.box = document.querySelector(box);
        this.body = document.querySelector('body');
    }

    closeByEsc(event){
          if (event.key === 'Escape') {
          this.box.classList.remove('exibir');
          this.btn.classList.remove('botao-sair');
          this.btn.classList.add('botao-mes-ano');
      }};

    openClose(customBtn, customBox) {
        const btn = customBtn ? document.querySelector(customBtn) : this.btn;
        const box = customBox ? document.querySelector(customBox) : this.box;

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
      this.body.addEventListener('keydown', (event) => this.closeByEsc(event));   
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