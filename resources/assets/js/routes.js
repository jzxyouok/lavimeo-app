import VueRouter from 'vue-router';




let routes = [
	{
		path: '/',
		name: 'HomePage',
		component: require('./pages/Home')
	},
    {
        path: '/trending',
        name: 'TrendingPage',
        component: require('./pages/Trending')
    },
    {
        path: '/subscriptions',
        name: 'SubscriptionPage',
        component: require('./pages/Subscription')
    },
    {
        path: '/channel/:id/:slug',
        name: 'ChannelPage',
        component: require('./pages/Channel'),
        props: true
    },
    {
        path: '/video/:id/:slug',
        name: 'VideoDetailPage',
        component: require('./pages/VideoDetail'),
        props: true
    },
    {
        path: '/upload',
        name: 'UploadPage',
        component: require('./pages/Upload'),
        beforeEnter: (to, from, next) => {
            if( window.Laravel.hasOwnProperty('Auth') ) {
                next(true);
            } else {
                next(false);
                alert('Please login to upload a video');
            }
        }
    },
    {
        path: '/account',
        name: 'AccountPage',
        component: require('./pages/Account'),
        beforeEnter: (to, from, next) => {
            if( window.Laravel.hasOwnProperty('Auth') ) {
                next(true);
            } else {
                next(false);
                alert('Please login to access your account page.');
            }
        }
    }
];


export default new VueRouter({
	routes,
	linkActiveClass: 'is-active'
});