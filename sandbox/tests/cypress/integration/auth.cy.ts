describe('auth', () => {
  beforeEach(() => {
    cy.logout()
  })

  it('log in', () => {
    cy
      .visit('/')
      .get('input[type="email"]')
      .clear()
      .type('admin@example.com')
      .get('input[type="password"]')
      .clear()
      .type('secret')
      .get('button[type="submit"]')
      .click()
      .url()
      .then(url => {
        throw new Error('URL: ' + url);
        expect(url.endsWith('/backend')).to.be.true
      })
  })

  it('log out', () => {
    cy
      .login({ email: 'admin@example.com' })
      .visit('/backend')
      .get('[data-cy="logout"]')
      .click()
      .url()
      .then(url => {
        throw new Error('URL: ' + url);
        expect(url.endsWith('/login')).to.be.true
      })
  })
})