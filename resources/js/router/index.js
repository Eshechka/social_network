import {createRouter, createWebHistory} from "vue-router"


const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: '/login',
            component: () => import('../components/Login.vue')
        },
        {
            path: '/register',
            component: () => import('../components/Register.vue')
        },
        {
            name: 'personal',
            path: '/personal',
            component: () => import('../components/Personal.vue')
        },
        {
            name: 'users',
            path: '/users',
            component: () => import('../components/Users.vue')
        },
        {
            name: 'user',
            path: '/user/:id',
            component: () => import('../components/User.vue')
        },
        {
            name: 'feed',
            path: '/users/following_posts',
            component: () => import('../components/FollowingPosts.vue')
        },
    ]
})

router.beforeEach((to, from, next) => {
    const token = localStorage.getItem('X_XSRF_TOKEN');

    axios.get('/api/user')
        .catch(e => {
            if (e.response.status === 401 && localStorage.key('X_XSRF_TOKEN')) {
                localStorage.removeItem('X_XSRF_TOKEN')
            }
        });

    if (!token) {
        if (to.path === '/login' || to.path === '/register') {
            return next();
        } else {
            return next({
                path: '/login'
            });
        }
    } else {
        if (to.path === '/login' || to.path === '/register') {
            return next({
                path: '/personal'
            });
        }
    }

    return next();
});

export default router;
