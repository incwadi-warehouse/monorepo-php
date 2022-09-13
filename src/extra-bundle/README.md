# baldeweg/extra-bundle

Offers tools for management of users, testing and setup.

## Getting Started

```shell
composer req baldeweg/extra-bundle
```

Activate the bundle in your `config/bundles.php`, if not done automatically.

```php
Baldeweg\Bundle\ExtraBundle\BaldewegExtraBundle::class => ['all' => true],
```

## User

Add optional routes to your `config/routes.yaml`. The `me` endpoint gives you some details of the current user. Change your password with the `password` endpoint. For more info have a look into the corresponding classes.

```yaml
me:
  path: /api/me
  controller: Baldeweg\Bundle\ExtraBundle\Service\MeUser::me
  methods: GET

password:
  path: /api/password
  controller: Baldeweg\Bundle\ExtraBundle\Service\PasswordUser::password
  methods: PUT
```

Define the `User` class in the `config/packages/baldeweg_extra.yaml`. You can omit this setting if you use `App\Entity\User`.

```yaml
baldeweg_extra:
  userclass: App\Entity\User
```

## Maker

- make:extra:subscriber - Create a Subscriber
