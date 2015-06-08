<?php
/**
 * Interface for GooglePlace Storage
 *
 * @author Nicolás Rivas <nicolasrivas07@gmail.com>
 */
namespace App\Repositories\Storage\GooglePlace;

/**
 * This Interface should be extendend for Database Storage of GooglePlace
 *
 *
 */
interface GooglePlaceRepositoryInterface
{

    /**
     * Get
     *
     * @param mixed $latitude
     * @param mixed $longitude
     * @return void
     */
    public function get($latitude, $longitude);

}
