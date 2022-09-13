# baldeweg/api-bundle

Offers tools for API's.

## Getting Started

```shell
composer req baldeweg/api-bundle
```

Activate the bundle in your `config/bundles.php`, if not done automatically.

```php
Baldeweg\Bundle\ApiBundle\BaldewegApiBundle::class => ['all' => true],
```

## Usage

```php
use Baldeweg\Bundle\ApiBundle\Serializer;

$fields = ['test', 'date', 'child.title'];

$serializer = new Serializer();
$serializer->serialize($entity, $fields);
```

There is also an abstract controller to give you access to these features within the controller.

```php
use Baldeweg\Bundle\ApiBundle\AbstractApiController;

// Contains the keys of the entity you need
$fields = ['id', 'name', 'user.id', 'createdAt:timestamp', 'comments:count'];

// JSON Response with serialized data
$this->setResponse()->single($fields, $genre); // single entity
$this->setResponse()->collection($fields, $genres); // array of entities
$this->setResponse()->invalid(); // Return message and 400 status code
$this->setResponse()->deleted(); // Return message and 200 status code

// Parse the data from the request and make them available to the form
$this->submitForm($request)
```

You can transform the values, just add a transformer after the field name e.g. `comments:count`.

At the moment only count and timestamp are available.

## test Trait

To make XHR requests easier, there is an `ApiTestTrait` trait available for use.

```php
use \Baldeweg\Bundle\ApiBundle\ApiTestTrait;
```

## Maker

- make:api:controller - Create a Controller
- make:api:test - Create a Test
