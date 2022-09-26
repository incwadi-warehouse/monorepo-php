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

```php
use Baldeweg\Bundle\ApiBundle\AbstractApiController;
use Baldeweg\Bundle\ApiBundle\Response;
use Baldeweg\Bundle\ApiBundle\Serializer;

$response = new Response(new Serializer());

// Contains the keys of the entity you need
$fields = ['id', 'name', 'user.id', 'createdAtTimestamp', 'commentsCount'];

// JSON Response with serialized data
$response->single($fields, $genre); // single entity
$response->collection($fields, $genres); // array of entities
$response->invalid(); // Return message and 400 status code
$response->deleted(); // Return message and 200 status code

// Parse the data from the request and make them available to the form
$this->submitForm($request)
```

## test Trait

To make XHR requests easier, there is an `ApiTestTrait` trait available for use.

```php
use \Baldeweg\Bundle\ApiBundle\ApiTestTrait;
```

## Maker

- make:api:controller - Create a Controller
- make:api:test - Create a Test
