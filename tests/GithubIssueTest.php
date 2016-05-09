<?php

use Cheapest\Exceptions\GithubIssue;
use Cheapest\Exceptions\Handler;

class GithubIssueTest extends TestCase
{
    /**
     * Tests what an issue created with partial information looks like (1/3)
     *
     * @throws \Exception
     */
    public function testPartialIssueOne()
    {
        try {
            throw new \ErrorException('1/3 A partial error.');
        } catch (\ErrorException $e) {
            Handler::createIssue($e->getMessage(), $e->getCode(), $e->getSeverity(), $e->getFile());
        }
    }

    /**
     * Tests what an issue created with partial information looks like (2/3)
     *
     * @throws \Exception
     */
    public function testPartialIssueTwo()
    {
        try {
            throw new \ErrorException('2/3 A partial error.');
        } catch (\ErrorException $e) {
            Handler::createIssue($e->getMessage(), null, null, null, $e->getLine(), $e->getTraceAsString());
        }
    }

    /**
     * Tests what an issue created with partial information looks like (3/3)
     *
     * @throws \Exception
     */
    public function testPartialIssueThree()
    {
        try {
            throw new \ErrorException('3/3 A partial error.');
        } catch (\ErrorException $e) {
            Handler::createIssue(null, null, null, $e->getFile(), null, $e->getTraceAsString());
        }
    }

    /**
     * Tests a valid full request
     *
     * @throws \ErrorException
     */
    public function testValidRequest()
    {
        try {
            throw new \ErrorException('An example exception title and message');
        } catch (\ErrorException $e) {
            $result = Handler::createIssue($e);

            $this->assertNotNull($result, 'null result received');
            $this->assertTrue(array_key_exists('duplicate', $result), 'duplicate parameter missing');
            if (!$result['duplicate']) {
                $this->assertTrue(array_key_exists('number', $result), 'id parameter missing');
                $this->assertTrue(array_key_exists('url', $result), 'url parameter missing');
                $this->assertTrue(is_int($result['number']), 'id must be an int');
                $this->assertTrue(is_string($result['url']), 'url must be a string');
                $this->assertNotFalse(filter_var($result['url'], FILTER_VALIDATE_URL), 'url must be a url (duh)');
                $this->assertEquals(false, $result['duplicate']);
            } else {
                $this->assertTrue(is_bool($result['duplicate']));
                $this->assertEquals(true, $result['duplicate']);
            }
        }
    }
}
