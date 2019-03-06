export default [
    {
        path: '/dashboard',
        name: 'Dashboard',
        view: 'Dashboard'
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
    },
    {
        path: '/clothes/:id',
        name: 'لباس',
        view: 'Clothing/Item'
    },
    {
        path: '/users',
        name: 'کاربر ها',
        view: 'Users'
    },
    {
        path: '/users/:id',
        name: 'کاربر',
        view: 'User/Item'
    },
    {
        path: '/typography',
        view: 'Typography'
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
