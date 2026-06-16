---
title: Force-delete action
---

## Overview

WellCMS includes a prebuilt action that is able to force-delete [soft deleted](https://laravel.com/docs/eloquent#soft-deleting) Eloquent records. When the trigger button is clicked, a modal asks the user for confirmation. You may use it like so:

```php
use WellCMS\Actions\ForceDeleteAction;

ForceDeleteAction::make()
    ->record($this->post)
```

If you want to force-delete table rows, you can use the `WellCMS\Tables\Actions\ForceDeleteAction` instead, or `WellCMS\Tables\Actions\ForceDeleteBulkAction` to force-delete multiple at once:

```php
use WellCMS\Tables\Actions\BulkActionGroup;
use WellCMS\Tables\Actions\ForceDeleteAction;
use WellCMS\Tables\Actions\ForceDeleteBulkAction;
use WellCMS\Tables\Table;

public function table(Table $table): Table
{
    return $table
        ->actions([
            ForceDeleteAction::make(),
            // ...
        ])
        ->bulkActions([
            BulkActionGroup::make([
                ForceDeleteBulkAction::make(),
                // ...
            ]),
        ]);
}
```

## Redirecting after force-deleting

You may set up a custom redirect when the form is submitted using the `successRedirectUrl()` method:

```php
ForceDeleteAction::make()
    ->successRedirectUrl(route('posts.list'))
```

## Customizing the force-delete notification

When the record is successfully force-deleted, a notification is dispatched to the user, which indicates the success of their action.

To customize the title of this notification, use the `successNotificationTitle()` method:

```php
ForceDeleteAction::make()
    ->successNotificationTitle('User force-deleted')
```

You may customize the entire notification using the `successNotification()` method:

```php
use WellCMS\Notifications\Notification;

ForceDeleteAction::make()
    ->successNotification(
       Notification::make()
            ->success()
            ->title('User force-deleted')
            ->body('The user has been force-deleted successfully.'),
    )
```

To disable the notification altogether, use the `successNotification(null)` method:

```php
ForceDeleteAction::make()
    ->successNotification(null)
```

## Lifecycle hooks

You can use the `before()` and `after()` methods to execute code before and after a record is force-deleted:

```php
ForceDeleteAction::make()
    ->before(function () {
        // ...
    })
    ->after(function () {
        // ...
    })
```
