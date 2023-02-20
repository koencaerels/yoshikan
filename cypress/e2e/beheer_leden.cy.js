describe('tests leden beheer module', () => {
  beforeEach(() => {
    cy.visit('http://localhost:8080/beheer');
    cy.get("input#login_username").type('test@administrator.com');
    cy.get("input#login_password").type('LKYRtYpEFJa');
    cy.get('button[type="submit"]').click();
    cy.get('.fa-user-circle').parent().click();
  });
  it('lists the subscription', () => {

  })
})
