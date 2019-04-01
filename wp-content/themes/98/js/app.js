require("babel-polyfill");

window.jQuery = window.$ = require('jquery');
window.Vue = require('vue');
window.axios = require("axios");
window._ = require("lodash");

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

require('./load-components');

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