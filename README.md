Yoshi-Kan Website + Ledenbeheer
===============================

---

<p style="padding-top:9px;"> 
<img src="https://img.shields.io/github/license/koencaerels/yoshikan?style=flat" alt="GitHub license">  
<img src="https://github.com/koencaerels/yoshikan/actions/workflows/php_build_and_qa_test.yml/badge.svg">
</p>

---

## Requirements

...

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
