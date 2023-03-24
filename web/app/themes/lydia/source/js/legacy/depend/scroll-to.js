/**
* Scroll To
* ---------
* @component Home
* @version 1.0
*/

function scrollToItem(element, container, offset) {
    element.on('click', function () {
        $('html, body').animate({
            scrollTop: container.offset().top - offset
        }, 1000);
    });
}