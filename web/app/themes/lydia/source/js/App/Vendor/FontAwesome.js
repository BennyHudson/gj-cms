/**
 * Font Awesome
 * ------
 * @package lydia/vendor
 * @version 1.0
 * @requires fontawesome-pro
 * @requires npm
 *
 * import {} from '@fortawesome/free-brands-svg-icons'
 * import {} from '@fortawesome/free-regular-svg-icons'
 * import {} from '@fortawesome/free-solid-svg-icons'
 * import {} from '@fortawesome/pro-regular-svg-icons'
 * import {} from '@fortawesome/pro-light-svg-icons'
 * import {} from '@fortawesome/pro-solid-svg-icons'
 * import {} from '@fortawesome/pro-solid-svg-icons'
 * import {} from'@fortawesome/pro-duotone-svg-icons';
 *
 * @url https://fontawesome.com/how-to-use/with-the-api/setup/importing-icons
 */

import { config, library, dom } from '@fortawesome/fontawesome-svg-core'

import { faLongArrowLeft } from '@fortawesome/pro-regular-svg-icons/faLongArrowLeft'
import { faLongArrowRight } from '@fortawesome/pro-regular-svg-icons/faLongArrowRight'
import { faLongArrowUp } from '@fortawesome/pro-regular-svg-icons/faLongArrowUp'
import { faSpinnerThird } from '@fortawesome/pro-light-svg-icons/faSpinnerThird'
import { faCheckCircle } from '@fortawesome/pro-light-svg-icons/faCheckCircle'
import { faExclamationCircle } from '@fortawesome/pro-light-svg-icons/faExclamationCircle'
import { faInfoCircle } from '@fortawesome/pro-duotone-svg-icons/faInfoCircle'
import { faChevronDown } from '@fortawesome/free-solid-svg-icons/faChevronDown'
import { faChevronLeft } from '@fortawesome/free-solid-svg-icons/faChevronLeft'
import { faChevronRight } from '@fortawesome/free-solid-svg-icons/faChevronRight'
import { faSearch } from '@fortawesome/pro-regular-svg-icons/faSearch'
import { faPlus } from '@fortawesome/pro-light-svg-icons/faPlus'
import { faMinus } from '@fortawesome/pro-light-svg-icons/faMinus'
import { faTimes } from '@fortawesome/pro-regular-svg-icons/faTimes'
import { faEnvelope } from '@fortawesome/free-regular-svg-icons/faEnvelope'
import { faPlay as faPlayRegular } from '@fortawesome/pro-regular-svg-icons/faPlay'
import { faPlay as faPlaySolid } from '@fortawesome/free-solid-svg-icons/faPlay'
import { faPlay as faPlayOutline } from '@fortawesome/pro-light-svg-icons/faPlay'
import { faPlayCircle } from '@fortawesome/free-solid-svg-icons/faPlayCircle'
import { faVolumeUp } from '@fortawesome/pro-regular-svg-icons/faVolumeUp'
import { faExternalLink } from '@fortawesome/pro-regular-svg-icons/faExternalLink'
import { faMapMarkerAlt } from '@fortawesome/free-solid-svg-icons/faMapMarkerAlt'
import { faTwitter } from '@fortawesome/free-brands-svg-icons/faTwitter'
import { faFacebook } from '@fortawesome/free-brands-svg-icons/faFacebook'
import { faLinkedin } from '@fortawesome/free-brands-svg-icons/faLinkedin'
import { faInstagram } from '@fortawesome/free-brands-svg-icons/faInstagram'
import { faAngleRight } from '@fortawesome/pro-regular-svg-icons/faAngleRight'


class FontAwesome {

    constructor() {
        this.setOptions();
        this.active();
        this.watch();
    }

    setOptions() {
        config.autoReplaceSvg = 'nest';
        config.observeMutations = true;
    }

    active() {
        library.add(
            faLongArrowLeft,
            faLongArrowRight,
            faLongArrowUp,
            faSpinnerThird,
            faCheckCircle,
            faExclamationCircle,
            faChevronDown,
            faChevronLeft,
            faChevronRight,
            faSearch,
            faInfoCircle,
            faPlus,
            faMinus,
            faTimes,
            faEnvelope,
            faPlayRegular,
            faPlaySolid,
            faVolumeUp,
            faExternalLink,
            faTwitter,
            faFacebook,
            faInstagram,
            faAngleRight,
            faLinkedin,
            faMapMarkerAlt,
            faPlayCircle,
            faPlayOutline,
            faChevronRight
        )
    }

    watch() {
        dom.watch();
    }
}

new FontAwesome();
