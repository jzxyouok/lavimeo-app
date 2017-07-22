import VueRouter from 'vue-router';




let routes = [
	{
		path: '/',
		name: 'HomePage',
		component: require('./pages/Home')
	}
];


export default new VueRouter({
	routes,
	linkActiveClass: 'is-active'
});