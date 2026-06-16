<x-wellcms::icon-button
    :badge="$unreadNotificationsCount ?: null"
    color="gray"
    icon="heroicon-o-bell"
    icon-alias="panels::topbar.open-database-notifications-button"
    icon-size="lg"
    :label="__('wellcms-panels::layout.actions.open_database_notifications.label')"
    class="fi-topbar-database-notifications-btn"
/>
