window.jQuery = window.$ = require('jquery');
window._ = require("lodash");
window.axios = require('axios')

import tether from 'tether';
global.Tether = tether;

require('bootstrap');

(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.8";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));

import Vue from 'vue' 

// require('./load-components');
Vue.component('omni-bar', require('./components/fields/OmniBar.vue').default);
Vue.component('acreage-field', require('./components/fields/Acreage.vue').default);
Vue.component('sqft-field', require('./components/fields/TotalSqft.vue').default);
Vue.component('bathrooms-field', require('./components/fields/Bathrooms.vue').default);
Vue.component('bedrooms-field', require('./components/fields/Bedrooms.vue').default);
Vue.component('max-price-field', require('./components/fields/MaxPrice.vue').default);
Vue.component('min-price-field', require('./components/fields/MinPrice.vue').default);
Vue.component('status-field', require('./components/fields/Status.vue').default);
Vue.component('property-type', require('./components/fields/PropertyType.vue').default);
Vue.component('area-field', require('./components/fields/Area.vue').default);
Vue.component('details-field', require('./components/fields/Details.vue').default);
Vue.component('listing-photo', require('./components/ListingPhoto.vue').default);

Vue.component('search-bar', require('./components/SearchBar.vue').default);
Vue.component('quick-search', require('./components/QuickSearch.vue').default);
Vue.component('sort-form', require('./components/SortForm.vue').default);
Vue.component('filter-form', require('./components/FilterForm.vue').default);
Vue.component('photo-gallery', require('./components/PhotoGallery.vue').default);
Vue.component('google-map', require('./components/GoogleMap.vue').default);
Vue.component('mini-listing', require('./components/MiniListing.vue').default);
Vue.component('favorite-button', require('./components/FavoriteButton.vue').default);

import PortalVue from 'portal-vue';
Vue.use(PortalVue);

import VueLazyload from 'vue-lazyload';

Vue.use(VueLazyload, {
  preLoad: 1.3,
  error: '/wp-content/themes/98/img/nophoto.jpg',
  loading: '/wp-content/themes/98/img/loading.svg',
  attempt: 1,
  observer: true,
  observerOptions: {
    rootMargin: '0px',
    threshold: 0.1
  }
})

let app = new Vue({

    el: '#page',

    data: {
        isScrolling: false,
        scrollPosition: 0,
        footerStuck: false,
        clientHeight: 0,
        windowHeight: 0,
        windowWidth: 0
    },

    methods: {

        toggleMenu () {
            this.isOpen = !this.isOpen;
        },

        handleScroll () {
            this.scrollPosition = window.scrollY;
            this.isScrolling = this.scrollPosition > 0;
        }

    },

    mounted () {
        this.footerStuck = window.innerHeight > this.$root.$el.clientHeight;
        this.clientHeight = this.$root.$el.clientHeight;
        this.windowHeight = window.innerHeight;
        this.windowWidth = window.innerWidth;
        this.handleScroll();
    },

    created () {
        window.addEventListener('scroll', this.handleScroll)
    },

    destroyed () {
        window.removeEventListener('scroll', this.handleScroll)
    }
});