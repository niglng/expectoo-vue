import {createRouter, createWebHistory} from 'vue-router';

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '/',
            name: 'Home',
            component: () => import('./pages/Index.vue'),
            meta: { transition: 'slide-left' },
        },
        {
            path: '/page/:id',
            name: 'nextpage',
            component: () => import('./pages/Index.vue'),
            props: true
        },
        {
            path: '/charater/:id',
            name: 'characterDetail',
            component: () => import('./pages/CharacterDetail.vue'),
            props: true,
            meta: { transition: 'slide-left' },
        },
        {
            path: '/dashboard',
            name: 'dashboard',
            component: () => import('./pages/DashBoard.vue')
        },
    ],
})

/* router.beforeEach((to, from, next) => {
    if (to.path !== '/' && to.path !== '/register' && !isAuthenticated()) {
        return next({path: '/'})
    }
    return next()
})

function isAuthenticated() {
    return Boolean(localStorage.getItem('APP_DEMO_USER_TOKEN'))
}
 */

export default router;
