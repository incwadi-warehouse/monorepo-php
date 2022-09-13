<?php

namespace Baldeweg\Bundle\ApiBundle;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;

trait ApiTestTrait
{
    protected KernelBrowser $client;

    public function setUp(): void
    {
        $this->buildClient();
    }

    protected function request(string $url, ?string $method = 'GET', ?array $params = [], ?array $content = [], int $statusCode = 200)
    {
        $this->client->request(
            $method,
            $url,
            $params,
            [],
            [],
            json_encode($content)
        );

        $this->assertEquals(
            $statusCode,
            $this->client->getResponse()->getStatusCode(),
            'Unexpected HTTP status code for method ' . $method . ' with url ' . $url . '!'
        );

        return json_decode($this->client->getResponse()->getContent());
    }

    protected function buildClient(): void
    {
        $this->client = static::createClient();
        $this->client->request(
            'POST',
            '/api/login_check',
            [],
            [],
            [
                'CONTENT_TYPE' => 'application/json',
            ],
            json_encode(
                [
                    'username' => 'admin',
                    'password' => 'password',
                ]
            )
        );
        $data = json_decode(
            $this->client->getResponse()->getContent(),
            true
        );
        $this->client->setServerParameter(
            'HTTP_Authorization',
            sprintf('Bearer %s', $data['token'])
        );
    }
}
