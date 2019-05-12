

export default [
    {
        path: '/dashboard',
        name: 'Dashboard',
        view: 'Dashboard',
        meta: { requiresAuth: true }
    },
    {
        path: '/user-profile',
        name: 'User Profile',
        view: 'UserProfile'
    },

    {
        path: '/clothes',
        name: 'لباس ها',
        view: 'Clothes',
        meta: { requiresAuth: true }

    },
    {
        path: '/clothes/:id',
        name: 'لباس',
        view: 'Clothing/Item',
        meta: { requiresAuth: true }

    },
    {

        path: '/users',
        name: 'کاربر ها',
        view: 'Users',
        meta: { requiresAuth: true }

    },
    {
        path: '/users/:id',
        name: 'کاربر',
        view: 'User/Item',
        meta: { requiresAuth: true }

    },
    {
        path: '/login',
        name: 'ورود',
        view: 'Auth/Login'

    },
    {
        path: '/icons',
        view: 'Icons'
    },
    {
        path: '/maps',
        view: 'Maps'
    },
    {
        path: '/notifications',
        view: 'Notifications'
    },
    {
        path: '/upgrade',
        name: 'Upgrade to PRO',
        view: 'Upgrade'
    }
]
