<?php

use WellCMS\Contracts\Plugin;
use WellCMS\WellCMSManager;

if (! function_exists('wellcms')) {
    /**
     * @return ($plugin is null ? WellCMSManager : Plugin)
     */
    function wellcms(?string $plugin = null): WellCMSManager | Plugin
    {
        /** @var WellCMSManager $wellcms */
        $wellcms = app('wellcms');

        if ($plugin !== null) {
            return $wellcms->getPlugin($plugin);
        }

        return $wellcms;
    }
}
