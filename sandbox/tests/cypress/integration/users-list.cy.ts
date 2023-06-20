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

  it('sorts by column', () => {
    cy.login()
      .visit('/backend/users/users')
      .get('[data-sort]')
      .should('not.exist')

      // initial should be ascending
      .get('[data-column="id"]')
      .click()
      .url()
      .should('include', 'sort=id,asc')
      .get('[data-column="id"] [data-sort="asc"]')
      .should('be.visible')

      // second should be descending
      .get('[data-column="id"]')
      .click()
      .url()
      .should('include', 'sort=id,desc')
      .get('[data-column="id"] [data-sort="desc"]')
      .should('be.visible')

      // third should un-sort the column
      .get('[data-column="id"]')
      .click()
      .url()
      .should('not.include', 'sort=')
      .get('[data-sort]')
      .should('not.exist')
  })

  it('paginates to next page', () => {
    cy.login()
      .visit('/backend/users/users')
      .get('[data-paginate-next')
      .should('be.visible')
      .click()
      .url()
      .should('include', 'page=2')
  })

  it('paginates to previous page', () => {
    cy.login()
      .visit('/backend/users/users?page=2')
      .get('[data-paginate-previous')
      .should('be.visible')
      .click()
      .url()
      .should('include', 'page=1')
  })

  it('paginates to last page', () => {
    cy.login()
      .visit('/backend/users/users')
      .get('[data-paginate-last')
      .should('be.visible')
      .click()
      .url()
      .should('include', 'page=3')
  })

  it('paginates to first page', () => {
    cy.login()
      .visit('/backend/users/users?page=3')
      .get('[data-paginate-first')
      .should('be.visible')
      .click()
      .url()
      .should('include', 'page=1')
  })

  it.skip('paginates to selected page', () => {
    cy.login()
      .visit('/backend/users/users')
      .get('[data-paginate-select]')
      .scrollIntoView()
      .should('be.visible')
      // .select('2')
      // .url()
      // .should('include', 'page=2')
  })
})
