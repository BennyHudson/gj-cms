/**
 * Subscriptions
 * ---------
 * @component App/Components
 * @version 1.0
 *
 */
'use strict';

// class Subscriptions {
//     constructor(el) {
//         this.plans = document.querySelectorAll(el);
//         if (this.plans == null) return;
//         this.subscriptionAddToCart();
//     }

//     subscriptionAddToCart() {
//         this.plans.forEach((entry) => {
//             entry.querySelector('.subscription-plan__submit').onclick = (
//                 event
//             ) => {
//                 fbq('track', 'AddToCart', {
//                     content_name: entry.dataset.title,
//                     content_category: 'Subscription',
//                     content_type: 'product',
//                     value: entry.dataset.price,
//                     currency: 'GBP',
//                 });
//             };
//         });
//     }
// }

// new Subscriptions('.subscription-plan');
