<?php

namespace WellCMS\Panel\Concerns;

use WellCMS\Support\Assets\Asset;
use WellCMS\Support\Facades\WellCMSAsset;

trait HasAssets
{
    /**
     * @var array<string, array<Asset>>
     */
    protected array $assets = [];

    /**
     * @param  array<Asset>  $assets
     */
    public function assets(array $assets, string $package = 'app'): static
    {
        $this->assets[$package] = [
            ...($this->assets[$package] ?? []),
            ...$assets,
        ];

        return $this;
    }

    public function registerAssets(): void
    {
        foreach ($this->assets as $package => $assets) {
            WellCMSAsset::register($assets, $package);
        }
    }
}
