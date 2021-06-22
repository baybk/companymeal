<?php

namespace App\Providers;

use Google_Client;
use Hypweb\Flysystem\GoogleDrive\GoogleDriveAdapter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use League\Flysystem\Filesystem;

class GoogleDriveServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Storage::extend('google', function($app, $config) {
            $client = new Google_Client();
            $client->setClientId($config['clientId']);
            $client->setClientSecret($config['clientSecret']);
            $client->refreshToken($config['refreshToken']);

            // $client->setRedirectUri($this->redirectUri);
            $client->setAccessType('offline');
            $client->setApprovalPrompt('force');
            // $client->setAccessToken('ya29.a0AfH6SMAwmdxWi9tpK-ZoKaQtoh7n80BhH_6hdhB4tXBSeRnjofDItRpeQifRZozPJyvqS0EzkVoGxlV0imme7oJTf4TqmvURIc9UXV0KU8Jc4Bq5_AaTSuaadyA1LzZ4T7KhN36kRwHjIH4ZMY-q4t4p9Ae1');

            $service = new \Google_Service_Drive($client);

            $options = [];
            if(isset($config['teamDriveId'])) {
                $options['teamDriveId'] = $config['teamDriveId'];
            }

            $adapter = new GoogleDriveAdapter($service, $config['folderId'], $options);

            return new Filesystem($adapter);
        });
    }
}
