/**
* Clubhouse Partner Card Modal Reveal
* ---------
* @component Clubhouse
* @version 1.0
*/
jQuery(document).ready(function($) {

    var $clubPartnerCard = $('.c-club-partner-card');
    var $clubPartnerCardBtn = $('.c-club-partner-card__actions__offer__btn');
    var $clubPartnerCardModal = $('.c-club-partner-card__modal');

    if(!$clubPartnerCard.length) {
        return;
    }

    function modalOpen($card) {
        var $parentCard = $card.closest($clubPartnerCard);

        $card.addClass('js-is-active');
        $parentCard.addClass('js-modal-is-active');
        $parentCard.find($clubPartnerCardModal).fadeIn(150);
    }

    function modalClose($card) {
        var $parentCard = $card.closest($clubPartnerCard);

        $card.removeClass('js-is-active');
        $parentCard.removeClass('js-modal-is-active');
        $parentCard.find($clubPartnerCardModal).fadeOut(150);
    }

    $clubPartnerCardBtn.on('click',function() {
        $this = $(this);

        if ($this.hasClass('js-is-active')) {
            modalClose($this);
        } else {
            modalOpen($this);
        }
    });

});