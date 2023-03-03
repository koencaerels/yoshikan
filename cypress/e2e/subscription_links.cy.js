describe('subscription links tests', () => {

  // -------------------------------------------------------------------------------------------------------------------
  // enable the central button on the homepage
  // -------------------------------------------------------------------------------------------------------------------

  it('verifies the button is available on the homepage', () => {
    cy.visit('http://localhost:8080/beheer');
    cy.get(".hide-button").click();
    cy.get("input#login_username").type('test@administrator.com');
    cy.get("input#login_password").type('LKYRtYpEFJa');
    cy.get('button[type="submit"]').click();
    cy.get('.toolbar-item__site').should("contain", "Yoshi Kan");
    cy.get('.profile__dropdown-toggler').should("contain", "Test Administrator");
    cy.get('.fa-home').first().parent().click();
    cy.get('#inschrijven-tab').click();
    cy.get('input[name="fields[toonInschrijving]"][type="hidden"]').then($input => {
      if ($input.val() === 'true') {
        // toon inschrijving should be visible on the homepage
      } else {
        // enable inschrijving on the homepage
        cy.get('label[for="fields[toonInschrijving]"]').click();
        cy.get('.btn-success').first().click();
      }
    });
    cy.get('.profile__dropdown-toggler').click();
    cy.get('.fa-sign-out-alt').eq(1).parent().click();
    cy.get('h1').should('contain', 'Yoshi Kan');
  });

  // -------------------------------------------------------------------------------------------------------------------
  // test the central button on the homepage
  // -------------------------------------------------------------------------------------------------------------------

  it('verifies the button is working on the homepage', () => {
    // go to the home page and search for a button
    cy.visit('http://localhost:8080/');
    cy.get(".hide-button").click();
    cy.get('[data-cy="home_subscription"]').should('contain', 'Online inschrijven');
    cy.get('[data-cy="home_subscription"]').should('have.attr', 'href').and('include', '/inschrijven');
    // test the homepage central button
    cy.intercept('GET', '/inschrijving/api/configuration').as('configurationCall');
    cy.get('[data-cy="home_subscription"]').click();
    cy.url().should('include', '/inschrijven');
    cy.get('h1').should('contain', 'Online inschrijven.');
    cy.wait('@configurationCall');
    cy.get('.text-xl').should('contain.text', 'Periode');
    // go back to the homepage
    cy.get('[data-cy="header_home"]').click();
    cy.url().should('include', '/');
    cy.get('[data-cy="home_subscription"]').should('contain', 'Online inschrijven');
  });

  // -------------------------------------------------------------------------------------------------------------------
  // test the footer link of the website
  // -------------------------------------------------------------------------------------------------------------------

  it('verifies the footer link is working', () => {
    cy.visit('http://localhost:8080/');
    cy.get(".hide-button").click();
    cy.get('[data-cy="footer_subscription"]').should('contain', 'Inschrijven');
    cy.intercept('GET', '/inschrijving/api/configuration').as('configurationCall');
    cy.get('[data-cy="footer_subscription"]').click();
    cy.url().should('include', '/inschrijven');
    cy.get('h1').should('contain', 'Online inschrijven.');
    cy.wait('@configurationCall');
    cy.get('.text-xl').should('contain.text', 'Periode');
    cy.get('[data-cy="header_home"]').click();
    cy.url().should('include', '/');
    cy.get('[data-cy="home_subscription"]').should('contain', 'Online inschrijven');
  });

  // -------------------------------------------------------------------------------------------------------------------
  // test the header navigation for subscription
  // -------------------------------------------------------------------------------------------------------------------

  it('verifies the header navigation is working', () => {
    cy.visit('http://localhost:8080/');
    cy.get(".hide-button").click();
    cy.get('.mdi-information').parent().should('contain.text','Praktische info');
    cy.intercept('GET', '/inschrijving/api/configuration').as('configurationCall');
    cy.get('[data-cy="header_subscription"]').click({force:true});
    cy.url().should('include', '/inschrijven');
    cy.get('h1').should('contain', 'Online inschrijven.');
    cy.wait('@configurationCall');
    cy.get('.text-xl').should('contain.text', 'Periode');
    cy.get('[data-cy="header_home"]').click();
    cy.url().should('include', '/');
    cy.get('[data-cy="home_subscription"]').should('contain', 'Online inschrijven');
  });

})
