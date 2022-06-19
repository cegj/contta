export default class Money {
    constructor(moneyElement, options) {
        this.element = moneyElement;
        this.options = options;
        //Options:
        //setColor: true/false
        //localeCurrency: [bool: true/false, str: language (opt), str: currency (opt), str: currency (opt)]

        this.init();
    }

    localeCurrency(customMoneySelector, customLanguage = this.options.localeCurrency[1], customCurrency = this.options.localeCurrency[2], customStyle = this.options.localeCurrency[3]) {

        const element = customMoneySelector ? document.querySelector(customMoneySelector) : this.element;
        const language = customLanguage ? customLanguage : 'pt-BR';
        const currency = customCurrency ? customCurrency : 'BRL';
        const style = customStyle ? customStyle : 'currency';

        if (!!+element.innerText || +element.innerText === 0) {
            const number = +element.innerText;
            element.innerText = number.toLocaleString(language, { style: style, minimumFractionDigits: 2, maximumFractionDigits: 2, currency: currency });
        }
    }

    setColor(customMoneySelector) {

        const element = customMoneySelector ? document.querySelector(customMoneySelector) : this.element;

        if (element.innerText > 0) {
            element.dataset.valueColor = "positive";
        } else if (element.innerText < 0) {
            element.dataset.valueColor = "negative";
        } else {
            element.dataset.valueColor = "zero";
        }
    }

    init() {
        if (this.options.setColor === true) {
            this.setColor();
        }

        if (this.options.localeCurrency === true || this.options.localeCurrency[0] === true) {
            this.localeCurrency();
        }
    }
}