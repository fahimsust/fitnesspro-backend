## Local setup

After cloning repo, cd into project root and ...

1. ```composer install --ignore-platform-reqs```
2. ```cp .env.example .env```
3. ```npm install```  Not sure we'll be doing any asset building or frontend work in this repo, but just in case
4. alias sail (https://laravel.com/docs/9.x/sail#configuring-a-bash-alias) and run ```sail up```
5. generate app key ```sail artisan key:generate```

## Commands

### DataMigrate

Copies legacy database, normalizes data and runs migrations to update structure.

```php
sail artisan DataMigrate:run
```

### Create old system dump

Migrate:refreshes the database, runs old_migrations to get database structure to match legacy db, then creates a schema dump of that and names "mysql-schema.old-system.sql"

```php
sail artisan app:create-old-system-dump
```

Be sure to rerun "migrate:fresh --seed" afterward to get database back to dev state.


## Frontend

- TBD - Likely separate repo with nuxt setup

## Conventions/Guidelines

### Emergencies

- "should bugs expose any data publicly or to unauthorized persons, immediately bring the application down with ```artisan down```"
- https://spatie.be/guidelines/emergencies

### Laravel/PHP

- https://spatie.be/guidelines/laravel-php

### Git

- https://spatie.be/guidelines/version-control

### Security

- https://spatie.be/guidelines/security

## Code Structure

### src/Domain

> Business logic grouped by domain/subject

Class Types:

- Models
- Actions
- Collections
- DTOs
- Events
- Exceptions (Domain Specific)
- Listeners
- QueryBuilders
- States
- Rules

### src/App

> Used to expose/present the domain code for their own unique use cases.  Code still be grouped by domains.  Does not need to (and will not) be a 1:1 match to src/Domain directories.

Class Types:

- Controllers
- Middleware
- Providers
- Requests
- Resources
- ViewModels
- Jobs
- Exceptions (App Levels)

### src/Support

> Code that is used everywhere

Class Types:

- Helper Functions and Classes
- General Purpose Classes
- General Middleware
