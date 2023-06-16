Cypress.Commands.add('assertRedirect', path => {
  cy.location('pathname').should('eq', `/${path}`.replace(/^\/\//, '/'))
})

Cypress.Commands.add('assertUrlEndsWith', str => {
  cy.url()
    .then(url => {
        expect(url.endsWith(str), `Expected [${url}] to end with [${str}]`).to.be.true
    })
});