<?php
/**
 * Controller for Instragram Resource
 *
 * @author Nicolás Rivas <nicolasrivas07@gmail.com>
 */
namespace App\Http\Controllers;

use App\Repositories\Storage\Instagram\InstagramRepositoryInterface;
use App\Repositories\Storage\GooglePlace\GooglePlaceRepositoryInterface;
use Response;

class InstagramController extends Controller
{
    /**
     * Error API
     */
    const ERROR_API = "APINotFoundError";

    /**
     * Error API Message
     */
    const ERROR_API_MESSAGE = "invalid media id";

    /**
     * Data Null
     */
    const DATA_NULL = "Null";

    /**
     * Data Null Message
     */
    const DATA_NULL_MESSAGE = "No data available";

    /**
     * Instagram
     *
     * @var Instagram
     */
    protected $instagram;

    /**
     * GooglePlace
     *
     * @var GooglePlace
     */
    protected $google_place;

    /**
     * Constructor of the class
     *
     * @param Instagram $instagram
     * @param GooglePlace $google_place
     */
    public function __construct(
        InstagramRepositoryInterface $instagram,
        GooglePlaceRepositoryInterface $google_place
    )
    {
        $this->instagram = $instagram;
        $this->google_place = $google_place;
    }

    /**
     * index display media location data
     *
     * @param  int $media_id
     * @return array $response
     */
    public function index($media_id)
    {
        $v = self::validateMedia($media_id);
        if ($v['status'] === 200) {
            $response = self::locationGenerator($media_id, $v['location']);
        } else {
            $response = $v['error'];
        }
        return Response::json($response, $v['status']);
    }

    /**
     * validateMedia it controls the input is numeric
     * and connect with Instagram API for location data
     *
     * @param  int $media_id
     * @return array response
     *         array response['location'] || response['error']
     *         int   response['status']
     **/
    private function validateMedia($media_id)
    {
        if (!empty((int) $media_id)) {
            $instagram = $this->instagram->getMedia($media_id);
            if (!empty($instagram)) {
                if (empty($instagram->meta->error_type)) {
                    $response = array(
                        'location' => $instagram->data->location,
                        'status' => 200
                    );
                } else {
                    $response = array(
                        'error' => array(
                            'error' => $instagram->meta->error_type,
                            'message' => $instagram->meta->error_message
                        ),
                        'status' => 409
                    );
                }
            } else {
                $response = array(
                    'error' => array(
                        'error' => self::DATA_NULL,
                        'message' => self::DATA_NULL_MESSAGE
                    ),
                    'status' => 409
                );
            }
        } else {
            $response = array(
                'error' => array(
                    'error' => self::ERROR_API,
                    'message' => self::ERROR_API_MESSAGE
                ),
                'status' => 409
            );
        }
        return $response;
    }

    /**
     * locationGenerator with the coordinates data, it connects to
     * Google Place API for get more information about location.
     * This function builds a location array ready to be listed.
     *
     * @param  int    $media_id
     * @param  array  $location
     * @return array  response
     *         int    response[id] instagram media id
     *         array  response[location][geopoint] coordinates
     *         string response[location][reference] coordinate reference
     *         provides by google
     *         string response[location][address] coordinate address
     *         provides by google
     *         int    response[location][id] instragram location id
     *         string response[location][name] instragram location name
     */
    public function locationGenerator($media_id, $location)
    {
        $response = array(
            'id' => $media_id,
            'location' => null
        );

        if (!empty($location->latitude) && !empty($location->longitude)) {
            $google_data = $this->google_place->get(
                $location->latitude, $location->longitude
            );
            $response['location'] = array(
                'geopoint' => array(
                    'latitude' => $location->latitude,
                    'longitude' => $location->longitude
                ),
                'reference' => $google_data['reference'],
                'address' => $google_data['address']
            );
        }
        if (!empty($location->id)) {
            $response['location']['id'] = $location->id;
        }
        if (!empty($location->name)) {
            $response['location']['name'] = $location->name;
        }

        return $response;
    }

}