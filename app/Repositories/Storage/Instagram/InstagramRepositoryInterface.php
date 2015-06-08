<?php
/**
 * Interface for Instagram Storage
 *
 * @author Nicolás Rivas <nicolasrivas07@gmail.com>
 */
namespace App\Repositories\Storage\Instagram;

/**
 * This Interface should be extendend for Database Storage of Instagram
 *
 *
 */
interface InstagramRepositoryInterface
{

    /**
     * Get
     *
     * @param mixed $media_id
     * @return void
     */
    public function getMedia($media_id);

}
