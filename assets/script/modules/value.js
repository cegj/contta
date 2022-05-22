export default class Value{
    constructor(valueElement, setColor){
        this.valueElement = valueElement;
        this.setColor = setColor;
    }

    showHideMoney(){
        // Move show-hide (showhide.js) into here
    }

    localeCurrency(){
        // Move localecurrency (budgetTable.js) into here
    }

    setColor(){
        // Refactor setValueColor here
    }

    setValueColor(customValueElement){

        const element = customValueElement ? document.querySelector(customValueElement) : this.valueElement;

        if (element.innerText > 0){
            element.dataset.valueColor = "positive";
        } else if (element.innerText < 0) {
            element.dataset.valueColor = "negative";
        } else {
            element.dataset.valueColor = "zero";
        }
    }

    initValue(){
        if (this.setColor){
            this.setValueColor();
        }
    }
}