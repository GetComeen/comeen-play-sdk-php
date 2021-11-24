<?php


namespace DynamicScreen\SdkPhp\Handlers;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\HtmlString;

abstract class BaseAuthProviderHandler
{
    protected static string $provider = 'unknown';
    protected array $data_buffer = [];

    abstract public function identifier();

    abstract public function name();

    abstract public function description();

    abstract public function icon();

    abstract public function color();

    abstract public function testConnection($request);

    public function provideData($settings = [])
    {

    }

    final public function getData($key)
    {
        $method = Arr::get($this->data_buffer, $key);
        if ($method && is_callable($method)) {
            return $method();
        }

        return [];
    }

    final protected function addData(string $key, callable $data): void
    {
        $this->data_buffer[$key] = $data;
    }

    public function toArray()
    {
        return [
            'identifier' => $this->identifier(),
            'name' => $this->name(),
            'description' => $this->description(),
            'color' => $this->color(),
            'icon' => $this->icon(),
            'logo' => $this->getLogoAsString(),
            'is_safe_to_be_public' => $this->isSafeToBePublic(),
        ];
    }

    public function processOptions($options)
    {
        return $options;
    }

    public function getCustomCreateStep2($account, $redirectUrl)
    {
        return false;
    }

    public function getAvailableAccounts()
    {
        return Account::accessible()
            ->ofDriver($this)
            ->get();
    }

    public function isSafeToBePublic()
    {
        return false;
    }

    public final function getDefaultAuthorizations()
    {
        if ($this->isSafeToBePublic()) {
            return HasAuthorizations::$EVERYBODY;
        }

        $userClass = get_class(Auth::user());
        $userId = Auth::id();

        return "{$userClass}:{$userId}";
    }

    public final function getLogoAsString()
    {
        $icon = $this->icon();
        if ($icon instanceof ImageIcon) {
            return asset($icon->getPath());
        }

        return $icon;
    }

    public final function getLogo()
    {
        $icon = $this->icon();
        if ($icon instanceof ImageIcon) {
            $src = asset($icon->getPath());
            return new HtmlString("<img src=\"{$src}\" alt=\"{$this->name()}\" style=\"width: 42px; height: 42px; object-fit: contain;\" />");
        }

        return new HtmlString("<i class=\"fal fa-fw fa-3x {$icon}\"></i>");
    }

    public final function getProviderIdentifier(): string
    {
        return static::$provider;
    }

}
