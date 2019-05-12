/**
 * Vue Router
 *
 * @library
 *
 * https://router.vuejs.org/en/
 */

// Lib imports
import Vue from 'vue'
import VueAnalytics from 'vue-analytics'
import Router from 'vue-router'
import Meta from 'vue-meta'

import Auth from "../auth";


//middleware

// Routes
import paths from './paths'


function route(path, view, name, beforeEnter, meta) {
    return {
        name: name || view,
        beforeEnter: beforeEnter,
        meta: meta,
        path,
        component: require(
            `../views/${view}.vue`
        ).default
        // component: (resovle) => import(
        //   `../views/${view}.vue`
        // ).then(resovle)
    }
}

Vue.use(Router);

//define routes
let routes = [];

routes.push({
    path: '*',
    redirect: '/dashboard'
});
paths.map(path => routes.push(route(path.path, path.view, path.name, path.beforeEnter, path.meta)));


// Create a new router
const router = new Router({
    mode: 'history',
    routes: routes,


    scrollBehavior(to, from, savedPosition) {
        if (savedPosition) {
            return savedPosition
        }
        if (to.hash) {
            return {selector: to.hash}
        }
        return {x: 0, y: 0}
    }
});


Vue.use(Meta);

// Bootstrap Analytics
// Set in .env
// https://github.com/MatteoGabriele/vue-analytics
if (process.env.GOOGLE_ANALYTICS) {
    Vue.use(VueAnalytics, {
        id: process.env.GOOGLE_ANALYTICS,
        router,
        autoTracking: {
            page: process.env.NODE_ENV !== 'development'
        }
    })
}


router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        // this route requires auth, check if logged in
        // if not, redirect to login page.
        if (!Auth.check()) {
            next({
                path: '/login',
                query: {redirect: to.fullPath}
            });
        } else {
            next();
        }
    } else {
        next(); // make sure to always call next()!
    }
})
export default router;
