Nova.booting((Vue, router, store) => {
  router.addRoutes([
    {
      name: 'nova-redirect-tester',
      path: '/nova-redirect-tester',
      component: require('./components/Tool'),
    },
  ])
})
