---
title: Badge Blade component
---

## Overview

The badge component is used to render a small box with some text inside:

```blade
<x-wellcms::badge>
    New
</x-wellcms::badge>
```

## Setting the size of a badge

By default, the size of a badge is "medium". You can make it "extra small" or "small" by using the `size` attribute:

```blade
<x-wellcms::badge size="xs">
    New
</x-wellcms::badge>

<x-wellcms::badge size="sm">
    New
</x-wellcms::badge>
```

## Changing the color of the badge

By default, the color of a badge is "primary". You can change it to be `danger`, `gray`, `info`, `success` or `warning` by using the `color` attribute:

```blade
<x-wellcms::badge color="danger">
    New
</x-wellcms::badge>

<x-wellcms::badge color="gray">
    New
</x-wellcms::badge>

<x-wellcms::badge color="info">
    New
</x-wellcms::badge>

<x-wellcms::badge color="success">
    New
</x-wellcms::badge>

<x-wellcms::badge color="warning">
    New
</x-wellcms::badge>
```

## Adding an icon to a badge

You can add an [icon](https://blade-ui-kit.com/blade-icons?set=1#search) to a badge by using the `icon` attribute:

```blade
<x-wellcms::badge icon="heroicon-m-sparkles">
    New
</x-wellcms::badge>
```

You can also change the icon's position to be after the text instead of before it, using the `icon-position` attribute:

```blade
<x-wellcms::badge
    icon="heroicon-m-sparkles"
    icon-position="after"
>
    New
</x-wellcms::badge>
```
