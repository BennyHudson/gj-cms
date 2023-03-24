/**
* Inview
* ---------
* @component App/Animations
* @version 1.0
*
*/

// Polyfill
import 'intersection-observer'

class Inview {

    constructor(el) {
        this.setupObserver()
        this.setElements(el);
    }

    setupObserver() {

        this.observer = new IntersectionObserver(
            (entries, observer) => {
                entries.forEach(entry => {
                    if(entry.isIntersecting) {
                        entry.target.classList.add('has-animated');
                        observer.unobserve(entry.target);
                    }
                });
            },
            {
                rootMargin: "0px 0px -100px 0px"
            }
        );
    }

    setElements(node) {
        document.querySelectorAll(node).forEach(el => this.observer.observe(el) );
    }
}

new Inview('[data-animate]');
