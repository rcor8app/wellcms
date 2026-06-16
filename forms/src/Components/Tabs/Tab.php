<?php

namespace WellCMS\Forms\Components\Tabs;

use WellCMS\Forms\Components\Component;
use WellCMS\Forms\Components\Contracts\CanConcealComponents;
use WellCMS\Support\Concerns\HasBadge;
use WellCMS\Support\Concerns\HasIcon;
use Illuminate\Support\Str;

class Tab extends Component implements CanConcealComponents
{
    use HasBadge;
    use HasIcon;

    /**
     * @var view-string
     */
    protected string $view = 'wellcms-forms::components.tabs.tab';

    final public function __construct(string $label)
    {
        $this->label($label);
        $this->id(Str::slug(Str::transliterate($label, strict: true)));
    }

    public static function make(string $label): static
    {
        $static = app(static::class, ['label' => $label]);
        $static->configure();

        return $static;
    }

    public function getId(): string
    {
        return $this->getContainer()->getParentComponent()->getId() . '-' . parent::getId() . '-tab';
    }

    /**
     * @return array<string, int | null>
     */
    public function getColumnsConfig(): array
    {
        return $this->columns ?? $this->getContainer()->getColumnsConfig();
    }

    public function canConcealComponents(): bool
    {
        return true;
    }
}
