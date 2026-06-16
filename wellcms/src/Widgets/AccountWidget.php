<?php

namespace WellCMS\Widgets;

class AccountWidget extends Widget
{
    protected static ?int $sort = -3;

    protected static bool $isLazy = false;

    /**
     * @var view-string
     */
    protected static string $view = 'wellcms-panels::widgets.account-widget';
}
