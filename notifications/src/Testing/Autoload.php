<?php

namespace WellCMS\Notifications\Testing;

use WellCMS\Notifications\Notification;

/**
 * @return TestCall | TestCase | mixed
 */
function assertNotified(Notification | string | null $notification = null)
{
    Notification::assertNotified($notification);

    return test();
}
