<?php
/**
 * Eloquent Instagram Repository
 *
 * @author Nicolás Rivas <nicolasrivas07@gmail.com>
 */
namespace App\Repositories\Storage\Instagram;

use Vinkla\Instagram\Facades\Instagram;

/**
 * This class is the implementation of the InstagramRepositoryInterface
 *  for Eloquent
 *
 */
class EloquentInstagramRepository implements InstagramRepositoryInterface
{

    /**
     * Get
     *
     * @param int $media_id
     * @return Instagram
     */
    public function getMedia($media_id)
    {
        return Instagram::connection('main')
            ->getMedia($media_id);
    }

}
