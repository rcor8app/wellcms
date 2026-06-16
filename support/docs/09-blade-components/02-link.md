---
title: Link Blade component
---

## Overview

The link component is used to render a clickable link that can perform an action:

```blade
<x-wellcms::link :href="route('users.create')">
    New user
</x-wellcms::link>
```

## Using a link as a button

By default, a link's underlying HTML tag is `<a>`. You can change it to be a `<button>` tag by using the `tag` attribute:

```blade
<x-wellcms::link
    wire:click="openNewUserModal"
    tag="button"
>
    New user
</x-wellcms::link>
```

## Setting the size of a link

By default, the size of a link is "medium". You can make it "small", "large", "extra large" or "extra extra large" by using the `size` attribute:

```blade
<x-wellcms::link size="sm">
    New user
</x-wellcms::link>

<x-wellcms::link size="lg">
    New user
</x-wellcms::link>

<x-wellcms::link size="xl">
    New user
</x-wellcms::link>

<x-wellcms::link size="2xl">
    New user
</x-wellcms::link>
```

## Setting the font weight of a link

By default, the font weight of links is `semibold`. You can make it `thin`, `extralight`, `light`, `normal`, `medium`, `bold`, `extrabold` or `black` by using the `weight` attribute:

```blade
<x-wellcms::link weight="thin">
    New user
</x-wellcms::link>

<x-wellcms::link weight="extralight">
    New user
</x-wellcms::link>

<x-wellcms::link weight="light">
    New user
</x-wellcms::link>

<x-wellcms::link weight="normal">
    New user
</x-wellcms::link>

<x-wellcms::link weight="medium">
    New user
</x-wellcms::link>

<x-wellcms::link weight="semibold">
    New user
</x-wellcms::link>
   
<x-wellcms::link weight="bold">
    New user
</x-wellcms::link>

<x-wellcms::link weight="black">
    New user
</x-wellcms::link> 
```

Alternatively, you can pass in a custom CSS class to define the weight:

```blade
<x-wellcms::link weight="md:font-[650]">
    New user
</x-wellcms::link>
```

## Changing the color of a link

By default, the color of a link is "primary". You can change it to be `danger`, `gray`, `info`, `success` or `warning` by using the `color` attribute:

```blade
<x-wellcms::link color="danger">
    New user
</x-wellcms::link>

<x-wellcms::link color="gray">
    New user
</x-wellcms::link>

<x-wellcms::link color="info">
    New user
</x-wellcms::link>

<x-wellcms::link color="success">
    New user
</x-wellcms::link>

<x-wellcms::link color="warning">
    New user
</x-wellcms::link>
```

## Adding an icon to a link

You can add an [icon](https://blade-ui-kit.com/blade-icons?set=1#search) to a link by using the `icon` attribute:

```blade
<x-wellcms::link icon="heroicon-m-sparkles">
    New user
</x-wellcms::link>
```

You can also change the icon's position to be after the text instead of before it, using the `icon-position` attribute:

```blade
<x-wellcms::link
    icon="heroicon-m-sparkles"
    icon-position="after"
>
    New user
</x-wellcms::link>
```

## Adding a tooltip to a link

You can add a tooltip to a link by using the `tooltip` attribute:

```blade
<x-wellcms::link tooltip="Register a user">
    New user
</x-wellcms::link>
```

## Adding a badge to a link

You can render a [badge](badge) on top of a link by using the `badge` slot:

```blade
<x-wellcms::link>
    Mark notifications as read

    <x-slot name="badge">
        3
    </x-slot>
</x-wellcms::link>
```

You can [change the color](badge#changing-the-color-of-the-badge) of the badge using the `badge-color` attribute:

```blade
<x-wellcms::link badge-color="danger">
    Mark notifications as read

    <x-slot name="badge">
        3
    </x-slot>
</x-wellcms::link>
```
