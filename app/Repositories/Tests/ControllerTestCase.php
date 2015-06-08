<?php
/**
 * Controller Test Case
 *
 * @author Nicolas Rivas <nicolsarivas07@gmail.com>
 */
namespace App\Repositories\Tests;

/**
 * Controller Test Case
 * Used for testing controllers
 *
 */
Abstract class ControllerTestCase extends \TestCase
{

    /**
     * Mock Object
     *
     * @var Object
     */
    private $mock;

    /**
     * Mocks the Eloquent model
     *
     * @return $mock Object
     */
    public function mock($class)
    {
        $mock = \Mockery::mock($class);

        $this->app->instance($class, $mock);

        return $mock;
    }

    /**
     * After tests
     *
     * @return void
     */
    public function tearDown()
    {
        \Mockery::close();
    }

    /**
     * Assert Response is JSON
     *
     * @return boolean
     */
    public function assertResponseIsJSON($response)
    {
        // The Response is JSON
        $this->assertEquals(
            'application/json',
            $response->headers->get('Content-Type')
        );
    }

    /**
     * Assert Response Error
     *
     * @return boolean
     */
    public function assertErrorResponse($response, $error, $message)
    {
        $data = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('error', $data);
        $this->assertContains($error, $data);
        $this->assertArrayHasKey('message', $data);
        $this->assertContains($error, $data);
    }

}
