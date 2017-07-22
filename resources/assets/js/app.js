require('./bootstrap');
import VueProgressBar from 'vue-progressbar'
Vue.use(VueProgressBar, {
    color: '#ce1126',
    failedColor: 'red',
    height: '2px'
});

Vue.component('video-thumb', require('./components/VideoThumb.vue'));








import router from './routes';

// // beforeEach route scroll to top
// router.beforeEach( (to, from, next) => {
//     window.scrollTo(0,0);
//     next(true);
// });

const app = new Vue({
    el: '#app',
    router,
    methods: {
        slug(str) {
            if ( ! str ) return '';
            return str.toLowerCase()
                .replace(/[^\w\s-]/g, '') // remove non-word [a-z0-9_], non-whitespace, non-hyphen characters
                .replace(/[\s_-]+/g, '-') // swap any length of whitespace, underscore, hyphen characters with a single -
                .replace(/^-+|-+$/g, ''); // remove leading, trailing -
        }
    },
    data: {
        auth: Laravel.Auth,
        channel : Laravel.Channel
    }
});
