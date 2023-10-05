class ColorfulButton {
    constructor(buttonElement) {
        this.element = buttonElement
        this.element.classList.add('colorful-button')
        this.element.addEventListener('click', this.onClickHandler)
        // добавил контекст
        this.onClickHandler = this.onClickHandler.bind(this)
        this.generateRandomColor = this.generateRandomColor.bind(this)
    }

    async onClickHandler() { // у всех функций с await внутри обязательно нужен async
        const sleep = (ms) => new Promise(resolve => setTimeout(() => resolve(), ms))
        // добавил все стили через .style
        this.element.style.transition = 'color 0.3s ease-out, background-color 0.3s ease-out'
        this.element.style.color = this.generateRandomColor()
        this.element.style.backgroundColor = this.generateRandomColor()
        await sleep(300)
        this.element.style.transition = ''
    }

    generateRandomColor() {
        const generateRandomInt = (start, end) => Math.round(Math.random() * end + start)
        const rgb = [
            generateRandomInt(0, 255),
            generateRandomInt(0, 255),
            generateRandomInt(0, 255),
        ]
        return `rgb(${rgb.join(',')})` // изменил ковычки и добавил запятую в join
    }
}

const buttons = document.querySelectorAll('button.myClass') // добавил свой класс, чтобы выбирать только конкретные кнопки, а не все на странице
for (const button of buttons) {
    new ColorfulButton(button)
}