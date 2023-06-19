describe('users list', () => {
  it('registers a nav item', () => {
    cy.login()
      .visit('/backend')
      .get('[data-nav-to="backend.users.index"]')
      .click()
      .assertUrlEndsWith('/backend/users/users')
  })

  it('hides nav from unauthorized users', () => {
    cy.loginAs('cindy@example.com')
      .visit('/backend')
      .get('[data-nav-to="backend.users.index"]')
      .should('not.exist')
  })

  it('redirects unauthorized users', () => {
    cy.loginAs('cindy@example.com')
      .visit('/backend/users', { failOnStatusCode: false })
      .get('[data-404]')
      .should('exist')
  })
})
