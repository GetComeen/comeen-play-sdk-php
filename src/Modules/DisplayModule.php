<?php

namespace ComeenPlay\SdkPhp\Modules;

use Illuminate\Support\Arr;
use ComeenPlay\SdkPhp\Interfaces\IDisplay;
use GuzzleHttp\Client;

class DisplayModule implements IDisplay
{
    private array $display = [];

    public function __construct(array $options)
    {
        $this->display = $options;
    }

    public function getId() {
        return Arr::get($this->display, 'id', null);
    }

    public function getName()
    {
        return Arr::get($this->display, 'name', '');
    }

    public function getLogoURL()
    {
        return Arr::get($this->display, 'logo_url', '');
    }

    public function getLanguage()
    {
        return Arr::get($this->display, 'language', 'en');
    }

    public function getTimezone()
    {
        return Arr::get($this->display, 'timezone', 'Etc/UTC');
    }

    public function getLocation()
    {
        return [
            'address' => Arr::get($this->display, 'address', ''),
            'lat' => Arr::get($this->display, 'lat', ''),
            'lng' => Arr::get($this->display, 'lng', '')
        ];
    }

    public function getOrientation()
    {
        return Arr::get($this->display, 'orientation', '');
    }

    public function getUnitSystem()
    {
        return Arr::get($this->display, 'unit_system', 'metric');
    }

    public function getClockFormat()
    {
        return Arr::get($this->display, 'clock_format', '24h');
    }

    public function getMetadata($key)
    {
        return Arr::get($this->display, "display_metadata.$key", []);
    }

    public function setMetadata($key, $value)
    {
        $client = new Client([
            'base_uri' => config('services.api.url')
        ]);

        $client->post("/display/upsert-metadata?api_key=" . Arr::get($this->display, 'api_key'), [
            'json' => [
                "key" => $key,
                "value" => $value
            ]
        ]);
    }

    public function refreshData()
    {
        $client = new Client([
            'base_uri' => config('services.api.url')
        ]);

        $client->post("/display/refresh-data?api_key=" . Arr::get($this->display, 'api_key'));
    }
}