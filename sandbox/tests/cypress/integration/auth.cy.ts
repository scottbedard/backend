describe('auth', () => {
  it('log in', () => {
    cy
      .visit('/')
      .get('input[type="email"]')
      .clear()
      .type('super-admin@example.com')
      .get('input[type="password"]')
      .clear()
      .type('secret')
      .get('button[type="submit"]')
      .click()
      .assertUrlEndsWith('/backend')
  })

  it('log out', () => {
    cy
      .loginAs('super-admin@example.com')
      .visit('/backend')
      .get('[data-cy="logout"]')
      .click()
      .url()
      .assertUrlEndsWith('/login')
  })
})