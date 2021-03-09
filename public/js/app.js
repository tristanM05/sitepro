class Portfolio{

    /**
     * 
     * @param {string} selecteur 
     */
    constructor(selector){
        this.activeContent = null
        this.activeItem = null
        this.container = document.querySelector(selector)
        if(this.container == null){
            throw new Error(`l'élément ${selector} n'existe pas`)
        }
        this.children = Array.prototype.slice.call(this.container.querySelectorAll('.js-item'))
        this.children.forEach((child) => {
            child.addEventListener('click', (e) => {
                e.preventDefault()
                this.show(child)
            })
        })
    }

    /**
     * affiche le contenu d'un projet
     * @param {HTMLElement} child 
     */
    show(child){
        let content = child.querySelector('.js-body').cloneNode(true)
        let offset = 0
        if(this.activeContent !== null){
            this.slideUp(this.activeContent)
            if(this.activeContent.offsetTop < child.offsetTop){
                offset = this.activeContent.offsetHeight
            }
        }
        if(this.activeItem === child){
            this.activeContent = null
            this.activeItem = null
        }else{
            child.after(content)
            this.slideDown(content)
            this.scrollTo(child)
            this.activeContent = content
            this.activeItem = child
        }
    }
    /**
     * masque l'element avec une animation
     * @param {HTMLElement} element 
     */
    slideDown(element){
        let height = element.offsetHeight
        element.style.height = '0px'
        element.style.transitionDuration = '.5s'
        element.offsetHeight//force le repaint
        element.style.height = height + 'px'
        window.setTimeout(function () {
            element.style.height = null
        }, 500)
    }

    /**
     * masque l'element avec une animation
     * @param {HTMLElement} element 
     */
    slideUp(element){
        let height = element.offsetHeight
        element.style.height = height + 'px'
        element.offsetHeight//force le repaint
        element.style.height = '0px'
        window.setTimeout(function () {
            element.parentNode.removeChild(element)
        }, 500)
    }

    /**
     * fait defiller la fenetre jusqu'a l'element
     * @param {HTMLELEMENT} element 
     * @param {int} offset
     */
    scrollTo(element, offset = 0){
        window.scrollTo({
            behavior: 'smooth',
            left: 0,
            top: element.offsetTop - offset
        })
    }
}

new Portfolio('#js-portfolio')