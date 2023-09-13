<?php

namespace ComeenPlay\SdkPhp\Modules;

use App\Signature\RequestSignatureGenerator;
use ComeenPlay\SdkPhp\Interfaces\IDisplay;
use Illuminate\Support\Arr;
use function app;

class DisplayModule implements IDisplay
{
    use UseApiClient;

    private array $display = [];

    public function __construct(array $options)
    {
        $this->display = $options;
    }

    public function getId()
    {
        return Arr::get($this->display, 'id', null);
    }

    public function getAPIKey()
    {
        return Arr::get($this->display, 'api_key', null);
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

    public function getModel()
    {
        return Arr::get($this->display, "player.model.name", []);
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
            'lng' => Arr::get($this->display, 'lng', ''),
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

    public function setMetadata($key, $value): void
    {
        self::createApiClient()
            ->post(
                "/display/upsert-metadata",
                app(RequestSignatureGenerator::class)->signRequestParameters([
                    'api_key' => $this->getAPIKey(),
                    "key" => $key,
                    "value" => $value,
                ])
            )
            ->throw();
    }

    public function refreshData(): void
    {
        self::createApiClient()
            ->post(
                '/display/refresh-data',
                app(RequestSignatureGenerator::class)->signRequestParameters([
                    'api_key' => $this->getAPIKey(),
                ])
            )
            ->throw();
    }
}
