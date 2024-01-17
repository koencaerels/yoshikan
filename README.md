Yoshi-Kan Website + Ledenbeheer
===============================

---

<p> 
<img src="https://img.shields.io/github/license/koencaerels/yoshikan?style=flat" alt="GitHub license">  
<img src="https://github.com/koencaerels/yoshikan/actions/workflows/php_build_and_qa_test.yml/badge.svg">
</p>

---

## Requirements

* A webserver (Apache, NGINX, ...) with PHP 8.2 or higher.
* [Symfony](https://symfony.com/): PHP 8.2 or higher and these PHP extensions (which are installed and enabled by default in most PHP 8 installations): 
Ctype, iconv, PCRE, Session, SimpleXML, and Tokenizer.
* [Composer](https://getcomposer.org/download/), which is used to install PHP packages.
* A database server (MySQL, PostgreSQL, SQLite, ... ) that is compatible with [Doctrine](https://www.doctrine-project.org/).
* Node.js,Yarn & NPM for the frontends build process.

### Third party services

* https://www.resend.com/ for sending emails concerning the two factor authentication
* https://www.brevo.com/ for sending the transactional emails
* https://www.mollie.com/ for the online payment services
* https://www.sentry.io/ for error logging and monitoring

You can configure these services in the `.env` file.

## Getting Started

### 1. Make a valid .env file

Copy the `.env.example` file to the `.env` file.   
The example file is made for direct use with the docker configuration,
so no modifications needed.

### 2. Start project with docker

    docker-compose up -d

The docker scripts include automatic download and installation for following
parts of the project:
* composer install for the php libraries (vendor folder)
* webpack: symfony webpack encore installation & production build* 
* vue 3: **member_module** installation & production build   
  * (disabled for now due to some permission problem when running it in dev mode)
* vuePress: installation & production build (docs)

#### These are available services:
* Website: http://localhost:8080
* Documentation: http://localhost:8081
* Mailhog(catcher): http://localhost:8025

### 3. Create & setup the database

If you are using docker, make sure you're in the php container terminal. 
This can be done with following command. 

    docker-compose exec php bash

With following commands you can create an empty database with the table structure setup.

```sh
php bin/console doctrine:database:create
php bin/console doctrine:schema:update --force
```

## Further reference

You can consult documentation site for extended information  
http://localhost:8081
