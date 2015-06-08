<?php
/**
 * Tests for Instagram Resource
 *
 * @author Nicolás Rivas <nicolasrivas07@gmail.com>
 */
use App\Repositories\Tests\ControllerTestCase;
use App\Http\Controllers\InstagramController;


/**
 * Tests for Instagram Resource extends from ControllerTestCase
 *
 */
class InstagramControllerTest extends ControllerTestCase
{

    /**
     * URL for resource
     *
     * @var string
     */
    protected $url = '/locations/instagram';

    /**
     * Initial setup for Test
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->mockInstagram = $this->mock(
            'App\Repositories\Storage\Instagram\InstagramRepositoryInterface'
        );

        $this->mockPlace = $this->mock(
            'App\Repositories\Storage\GooglePlace\GooglePlaceRepositoryInterface'
        );
    }

    /**
     * Test Index Wrong media_id.
     *
     * @return void
     */
    public function testIndexWrongId()
    {
        $response = $this->call('GET', $this->url . "/a");

        $this->assertResponseStatus(409);

        $this->assertResponseIsJSON($response);

        $this->assertErrorResponse(
            $response,
            InstagramController::ERROR_API,
            InstagramController::ERROR_API_MESSAGE
        );
    }

    /**
     * Test Index Instagram Error.
     *
     * @return void
     */
    public function testIndexInstagramError()
    {
        $mockMeta = new stdClass();
        $mockMeta->error_type = 'error';
        $mockMeta->error_message = 'message';

        $mockInstagram = new stdClass();
        $mockInstagram->meta = $mockMeta;

        $this->mockInstagram
            ->shouldReceive('getMedia')
            ->once()
            ->andReturn($mockInstagram);

        $response = $this->call('GET', $this->url . "/123456");

        $this->assertResponseStatus(409);

        $this->assertResponseIsJSON($response);

        $this->assertErrorResponse(
            $response,
            'error',
            'message'
        );
    }

    /**
     * Test Index Null.
     *
     * @return void
     */
    public function testIndexNull()
    {
        $this->mockInstagram
            ->shouldReceive('getMedia')
            ->once()
            ->andReturn(null);

        $response = $this->call('GET', $this->url . "/123456");

        $this->assertResponseStatus(409);

        $this->assertResponseIsJSON($response);

        $this->assertErrorResponse(
            $response,
            InstagramController::DATA_NULL,
            InstagramController::DATA_NULL_MESSAGE
        );
    }

    /**
     * Test Index Succes.
     *
     * @return void
     */
    public function testIndexSucces()
    {
        $mockData = new stdClass();
        $mockData->location = true;

        $mockInstagram = new stdClass();
        $mockInstagram->data = $mockData;

        $this->mockInstagram
            ->shouldReceive('getMedia')
            ->once()
            ->andReturn($mockInstagram);

        $response = $this->call('GET', $this->url . "/123456");

        $this->assertResponseStatus(200);

        $this->assertResponseIsJSON($response);
    }

}
