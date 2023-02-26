describe('several page loading specs', () => {
  it('loads the homepage', () => {
    cy.visit('http://localhost:8080');
    cy.get(".home").should("contain","Yoshi-Kan");
  });
  it('consents cookies functionalities via modal screen', () => {
    cy.visit('http://localhost:8080');
    //-- check some footer related information ---------------------------------------------------------------
    cy.get(".hide-button").click();
    cy.get(".cc-text").should("contain","Yoshi-Kan");
    cy.get(".ccb__edit").should("contain","Cookie Settings");
    cy.get(".consent-give").should("contain","Accepteer alle cookies");
    //-- open the cookie modal and check the elements -------------------------------------------------------
    cy.get(".ccb__edit").click();
    cy.get("#ccm__content__title").should("contain","Cookie settings");
    cy.get(".ccm__tab-trigger").should("contain","Noodzakelijke Cookies");
    cy.get(".ccm__tab-trigger").should("contain","Analytics Cookies");
    cy.get("#ccm__footer__consent-modal-submit").should("contain","Bewaar de huidige settings");
    cy.get(".consent-give").should("contain","Accepteer alle cookies and sluit");
    //-- open the cookie settings panel ---------------------------------------------------------------------
    cy.get(".ccm__tab-trigger").first().click();
    cy.get(".ccm__tab-content__desc h3").should("contain","Noodzakelijke Cookies");
    cy.get(".ccm__tab-trigger").first().click();
    //-- accept the cookies ---------------------------------------------------------------------------------
    cy.get(".consent-give").first().click();
    cy.get('#cconsent-bar').should('not.be.visible');
  });
  it('consents cookies functionalities via footer button', () => {
    cy.visit('http://localhost:8080');
    //-- check some footer related information ---------------------------------------------------------------
    cy.get(".hide-button").click();
    cy.get(".cc-text").should("contain","Yoshi-Kan");
    cy.get(".ccb__edit").should("contain","Cookie Settings");
    cy.get(".consent-give").should("contain","Accepteer alle cookies");
    //-- accept the cookies ---------------------------------------------------------------------------------
    cy.get(".consent-give").eq(1).click();
    cy.get('#cconsent-bar').should('not.be.visible');
  });

})
