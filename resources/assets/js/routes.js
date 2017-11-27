import VueRouter from 'vue-router';

let routes = [
    {
        path: '/',
        component: require('./views/Home')
    },
    {
        path: '/videos/:id',
        component: require('./views/Video')
    }
];


export default new VueRouter({
    routes
});