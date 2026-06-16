<?php

namespace WellCMS\Widgets;

class WellCMSInfoWidget extends Widget
{
    protected static ?int $sort = -2;

    protected static bool $isLazy = false;

    /**
     * @var view-string
     */
    protected static string $view = 'wellcms-panels::widgets.wellcms-info-widget';
}
