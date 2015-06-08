<?php
/**
 * Eloquent GooglePlace Repository
 *
 * @author Nicolás Rivas <nicolasrivas07@gmail.com>
 */
namespace App\Repositories\Storage\GooglePlace;

use GuzzleHttp;
use Config;

/**
 * This class is the implementation of the GooglePlaceRepositoryInterface
 *  for Eloquent
 *
 */
class EloquentGooglePlaceRepository implements GooglePlaceRepositoryInterface
{

    /**
     * Get
     *
     * @param float $latitude
     * @param float $longitude
     * @return array || null $response
     */
    public function get($latitude, $longitude)
    {
        $response = array (
            'reference' => null,
            'address' => null
        );
        try {
            $client = new GuzzleHttp\Client();
            $resource = $client->get(
                Config::get('google.url'), array(
                    'query' => array(
                        'key' =>  Config::get('google.key'),
                        'location' => $latitude . ',' . $longitude,
                        'radius' => 1
                    )
                )
            );
        } catch (Exception $e) {
            $response = array (
                'reference' => 'No data available',
                'address' => 'No data available'
            );
        }
        if (!empty($data = $resource->getBody())) {
            $data = json_decode($data);
            if (
                !empty($data->results[0]->name) &&
                !empty($data->results[0]->vicinity)
            ) {
                $response = array (
                    'reference' => $data->results[0]->name,
                    'address' => $data->results[0]->vicinity
                );
            }
        }
        return $response;
    }

}
