describe('users list', () => {
  it('redirects from the index', () => {
      cy
        .login()
        .visit('/backend/users')
        .assertUrlEndsWith('/backend/users/users')
  });
});
