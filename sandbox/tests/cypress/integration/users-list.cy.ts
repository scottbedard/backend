describe('users list', () => {
  it('blocks unauthorized users', () => {
    // ...
  })

  it('registers a nav item', () => {
    cy
      .login()
      .visit('/backend')
      .get('[data-nav-to="backend.users.index"]')
      .click()
      .assertUrlEndsWith('/backend/users/users')
  })
})
