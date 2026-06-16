<?php

namespace WellCMS\Tables\Columns;

/**
 * @deprecated Use `TextColumn` with the `badge()` method instead.
 */
class BadgeColumn extends TextColumn
{
    public function isBadge(): bool
    {
        return true;
    }
}
