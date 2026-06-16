---
title: Delete action
---

## Overview

WellCMS includes a prebuilt action that is able to delete Eloquent records. When the trigger button is clicked, a modal asks the user for confirmation. You may use it like so:

```php
use WellCMS\Actions\DeleteAction;

DeleteAction::make()
    ->record($this->post)
```

If you want to delete table rows, you can use the `WellCMS\Tables\Actions\DeleteAction` instead, or `WellCMS\Tables\Actions\DeleteBulkAction` to delete multiple at once:

```php
use WellCMS\Tables\Actions\BulkActionGroup;
use WellCMS\Tables\Actions\DeleteAction;
use WellCMS\Tables\Actions\DeleteBulkAction;
use WellCMS\Tables\Table;

public function table(Table $table): Table
{
    return $table
        ->actions([
            DeleteAction::make(),
            // ...
        ])
        ->bulkActions([
            BulkActionGroup::make([
                DeleteBulkAction::make(),
                // ...
            ]),
        ]);
}
```

## Redirecting after deleting

You may set up a custom redirect when the record is deleted using the `successRedirectUrl()` method:

```php
DeleteAction::make()
    ->successRedirectUrl(route('posts.list'))
```

## Customizing the delete notification

When the record is successfully deleted, a notification is dispatched to the user, which indicates the success of their action.

To customize the title of this notification, use the `successNotificationTitle()` method:

```php
DeleteAction::make()
    ->successNotificationTitle('User deleted')
```

You may customize the entire notification using the `successNotification()` method:

```php
use WellCMS\Notifications\Notification;

DeleteAction::make()
    ->successNotification(
       Notification::make()
            ->success()
            ->title('User deleted')
            ->body('The user has been deleted successfully.'),
    )
```

To disable the notification altogether, use the `successNotification(null)` method:

```php
DeleteAction::make()
    ->successNotification(null)
```

## Lifecycle hooks

You can use the `before()` and `after()` methods to execute code before and after a record is deleted:

```php
DeleteAction::make()
    ->before(function () {
        // ...
    })
    ->after(function () {
        // ...
    })
```
