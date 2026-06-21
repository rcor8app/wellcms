@props([
    'heading' => null,
    'subheading' => null,
])

<div {{ $attributes->class(['re-simple-page']) }}>
    {{ \WellCMS\Support\Facades\WellCMSView::renderHook(\WellCMS\View\PanelsRenderHook::SIMPLE_PAGE_START, scopes: $this->getRenderHookScopes()) }}

    <section class="grid auto-cols-fr gap-y-6">
        <x-wellcms-panels::header.simple
            :heading="$heading ??= $this->getHeading()"
            :logo="$this->hasLogo()"
            :subheading="$subheading ??= $this->getSubHeading()"
        />

        {{ $slot }}
    </section>

    @if (! $this instanceof \WellCMS\Tables\Contracts\HasTable)
        <x-wellcms-actions::modals />
    @endif

    {{ \WellCMS\Support\Facades\WellCMSView::renderHook(\WellCMS\View\PanelsRenderHook::SIMPLE_PAGE_END, scopes: $this->getRenderHookScopes()) }}
</div>
