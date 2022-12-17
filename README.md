Yoshi-Kan Website + Ledenbeheer
===============================

### 4. Create & setup the database

With following commands you can create an empty database with the table structure setup.
If you are using docker, make sure you're in the container terminal (see above).

```sh
php bin/console doctrine:database:create
php bin/console doctrine:schema:update --force
```


Bolt CMS is an open source, adaptable platform for building and running modern websites. Built on PHP, Symfony and more. [Read the site](https://boltcms.io) for more info. 

## The tests

### Static analysis
- [**ECS - Easy Coding Standard**](https://github.com/symplify/easy-coding-standard)

[The `ecs.php` configuration file is located at the root of the cms project](./ecs.php)

```bash
# With Composer
composer lint                         # Launch ECS in dry run mode (command to launch in a Continuous Integration)
composer lint:fix                     # Launch ECS in fix mode

# With Docker
docker-compose exec php composer lint # Launch ECS by the php container
```

- [**PHPStan - PHP Static Analysis Tool**](https://github.com/phpstan/phpstan)

[The `phpstan.neon` configuration file is located at the root of the cms project](./phpstan.neon)

```bash
# With Composer
composer phpstan                         # Launch PHPStan (command to launch in a Continuous Integration)

# With Docker
docker-compose exec php composer phpstan # Launch PHPStan by the php container
```
