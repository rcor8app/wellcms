<?php

namespace WellCMS\Support\Assets;

class AlpineComponent extends Asset
{
    public function getPublicPath(): string
    {
        return public_path($this->getRelativePublicPath());
    }

    public function getRelativePublicPath(): string
    {
        $path = config('wellcms.assets_path', '');

        return ltrim("{$path}/js/{$this->getPackage()}/components/{$this->getId()}.js", '/');
    }

    public function getSrc(): string
    {
        return asset($this->getRelativePublicPath()) . '?v=' . $this->getVersion();
    }
}
