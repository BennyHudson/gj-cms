/**
* BackTop
* ---------
* @component App/Foundation
* @version 1.0
*
*/
'use strict';

class BackTop {

    constructor(el) {
        this.el = document.querySelector(el);
        if (this.el == null) return;
        this.scrollTop();
    }

    scrollTop() {

        this.el.onclick = () => {
            window.scroll({
                top: 0,
                left: 0,
                behavior: 'smooth'
            });
        };

    }
}
new BackTop('.c-foundation-backtop');
