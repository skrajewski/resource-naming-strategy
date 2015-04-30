Resource Naming Strategy
=======================
[![building](https://img.shields.io/travis/skrajewski/resource-naming-strategy.svg)](https://travis-ci.org/skrajewski/resource-naming-strategy)
[![codeclimate](https://img.shields.io/codeclimate/github/skrajewski/resource-naming-strategy.svg)](https://codeclimate.com/github/skrajewski/resource-naming-strategy)
[![version](https://img.shields.io/packagist/v/szykra/resource-naming-strategy.svg)](https://packagist.org/packages/szykra/resource-naming-strategy)
[![license](https://img.shields.io/packagist/l/szykra/resource-naming-strategy.svg)](https://packagist.org/packages/szykra/resource-naming-strategy)

Resource Naming Strategy for Doctrine ORM

## Why _Resource_?
This naming strategy following the natural way of thinking about _entities_ and _resources_. Imagine that you have __one Flower__. It's single entity. You want to store some data about __flowers__ e.g. in your database. It's _resource_.

Simple? I know resource named _flower_ sounds easier but sometimes it's more confusing. In the end, you have a lot of flowers, not one.

This strategy is similar to the _Laravel_ naming convention (See [mapping](#mapping) section).

## Instalation

### Install via composer
Add dependecy to your `composer.json` file and run `composer update`.

```json
"require": {
    "szykra/resource-naming-strategy": "~0.1"
}
```

## Usage

### Usage with Doctrine
```php
$namingStrategy = new \Szykra\NamingStrategy\ResourceNamingStrategy();
$configuration()->setNamingStrategy($namingStrategy);
```

### Usage with Symfony
You have a two ways to use this naming strategy

#### Register bundle in `AppKernel.php`
Just open your `AppKernel.php` file and register new symfony bundle which contains a service definition.

```php
$bundles = array(
    ...
    new Szykra\NamingStrategy\ResourceNamingBundle\ResourceNamingBundle()
);
```

Now you can configure Doctrine in `config.yml` to use new naming strategy.

```yml
doctrine:
    orm:
        naming_strategy: szykra.naming_strategy.resource_naming_strategy
```

### Define your own service
If you don't want to register additional bundles you can create own service definiton in `services.yml`:

```yml
services:
    app.naming_strategy.resource:
        class: Szykra\NamingStrategy\ResourceNamingStrategy
```

And don't forget to configure Doctrine to use this service.

## Mapping
### Entity to table name
Lowercase and plural

| Entity       	| Table           	|
|--------------	|-----------------	|
| User         	| users           	|
| Category     	| categories      	|
| TaskActivity 	| task_activities 	|

### Property to column name
Lowercase letters and words separated by the underscore

| Property            | Column                |
|---------------------|-----------------------|
| firstName           | first_name            |
| LastName            | last_name             |
| secondRememberToken | second_remember_token |


### Embedded field to column name
Lowercase letters and words separated by the underscore

| Property from embedded `Address` | Column                   |
|----------------------------------|--------------------------|
| street                           | address_street           |
| postcode                         | address_postcode         |
| addressLineOne                   | address_address_line_one |

### Join column name
Lowercase letters and words separated by the underscore with *_id* suffix

| Property            | Column                |
|---------------------|-----------------------|
| reporter            | reporter_id           |
| task_activity       | task_activity_id      |

### Join table name
Two singular lowercase entity names in ascending order with words separated by the underscore

| Entity 1 | Entity 2 | Table         |
|----------|----------|---------------|
| User     | Task     | task_user     |
| Comment  | Post     | comment_post  |
| Work     | TimeLog  | time_log_work |

## License
The MIT License. Copyright &copy; 2015 Szymon Krajewski.
