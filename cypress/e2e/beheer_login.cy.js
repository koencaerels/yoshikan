describe('visit beheer login page & login', () => {
  beforeEach(() => {
    cy.visit('http://localhost:8080/beheer');
    cy.get(".hide-button").click();
    cy.get("input#login_username").type('test@administrator.com');
    cy.get("input#login_password").type('LKYRtYpEFJa');
    cy.get('button[type="submit"]').click();
  });
  it('logs in as test administrator', () => {
    cy.get('.toolbar-item__site').should("contain", "Yoshi Kan");
    cy.get('.profile__dropdown-toggler').should("contain", "Test Administrator");
  });
})
