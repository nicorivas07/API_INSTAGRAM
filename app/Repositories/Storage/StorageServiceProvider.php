<?php
/**
 * Storage Service Provider
 *
 * @author Nicolas Rivas <nicolasrivas07@gmail.com>
 */
namespace App\Repositories\Storage;

use Illuminate\Support\ServiceProvider;

/**
 * This class is used for Laravel to Dependency Inject the Storages classes
 *
 *
 */
class StorageServiceProvider extends ServiceProvider
{

    // Triggered automatically by Laravel
    public function register()
    {
        $this->app->bind(
            'App\Repositories\Storage\Instagram\InstagramRepositoryInterface',
            'App\Repositories\Storage\Instagram\EloquentInstagramRepository'
        );
        $this->app->bind(
            'App\Repositories\Storage\GooglePlace\GooglePlaceRepositoryInterface',
            'App\Repositories\Storage\GooglePlace\EloquentGooglePlaceRepository'
        );
    }

}
