<?php

require_once 'goutte.phar';

class ApiMethodsTest extends \PHPUnit_Framework_TestCase {

    private $endpoint = 'http://localhost:82';
    private $client;

    public function setUp() {
        $this->client = new \Goutte\Client();
    }

    public function testGetStatuses() {
        // GET
        $this->client->request('GET', sprintf('%s/statuses', $this->endpoint));
        $response = $this->client->getResponse();
        $this->assertEquals(200, $response->getStatus());
        $this->assertEquals('text/html', $response->getHeader('Content-Type'));
    }

    public function testGetStatusesId404() {
        $this->client->request('GET', sprintf('%s/statuses/0', $this->endpoint));
        $response = $this->client->getResponse();
        $this->assertEquals(404,$response->getStatus());
    }

    public function testGetStatusesId() {
        $this->client->request('GET', sprintf('%s/statuses/12', $this->endpoint));
        $response = $this->client->getResponse();
        $this->assertEquals(200,$response->getStatus());
    }

    public function testDeleteStatusesId() {
        $this->client->request('DELETE', sprintf('%s/statuses/12', $this->endpoint));
        $response = $this->client->getResponse();
        $this->assertEquals(200,$response->getStatus());
    }

    public function testRegister() {
        $this->client->request('GET', sprintf('%s/register', $this->endpoint));
        $response = $this->client->getResponse();
        $this->assertEquals(200,$response->getStatus());
    }

    public function testRegisterPost() {
        $this->client->request('POST', sprintf('%s/register?user=test&password=test', $this->endpoint));
        $response = $this->client->getResponse();
        $this->assertEquals(200,$response->getStatus());
        $this->client->request('POST', sprintf('%s/register?user=test&password=test', $this->endpoint));
    }

}



