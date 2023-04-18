describe('sandbox auth', () => {
  it('login as admin', () => {
    cy
      .logout()
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
        expect(url.endsWith('/backend')).to.be.true
      })
  })
})