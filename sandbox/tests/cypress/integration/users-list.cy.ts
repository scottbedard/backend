describe('users list', () => {
  it('blocks unauthorized users', () => {
    cy.loginAs('cindy@example.com')
      .visit('/backend/users')
      .get('@get')
      .should('have.property', 'status', 403)
  })

  it('registers a nav item', () => {
    cy.login()
      .visit('/backend')
      .get('[data-nav-to="backend.users.index"]')
      .click()
      .assertUrlEndsWith('/backend/users/users')
  })
})
