Nova.booting((Vue, router) => {
    router.addRoutes([
        {
            name: 'generate-newsletter',
            path: '/generate-newsletter',
            component: require('./components/Tool'),
        },
    ])
})
