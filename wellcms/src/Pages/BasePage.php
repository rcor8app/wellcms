<?php

namespace WellCMS\Pages;

use Closure;
use WellCMS\Actions\Concerns\InteractsWithActions;
use WellCMS\Actions\Contracts\HasActions;
use WellCMS\Forms\Concerns\InteractsWithForms;
use WellCMS\Forms\Contracts\HasForms;
use WellCMS\Infolists\Concerns\InteractsWithInfolists;
use WellCMS\Infolists\Contracts\HasInfolists;
use WellCMS\Support\Enums\Alignment;
use WellCMS\Support\Enums\MaxWidth;
use WellCMS\Support\Exceptions\Halt;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

abstract class BasePage extends Component implements HasActions, HasForms, HasInfolists
{
    use InteractsWithActions;
    use InteractsWithForms;
    use InteractsWithInfolists;

    protected static string $layout = 'wellcms-panels::components.layout.base';

    protected static ?string $title = null;

    protected ?string $heading = null;

    protected ?string $subheading = null;

    protected static string $view;

    public static ?Closure $reportValidationErrorUsing = null;

    protected ?string $maxContentWidth = null;

    /**
     * @var array<mixed>
     */
    protected array $extraBodyAttributes = [];

    public static string | Alignment $formActionsAlignment = Alignment::Start;

    public static bool $formActionsAreSticky = false;

    public static bool $hasInlineLabels = false;

    public function render(): View
    {
        return view($this->getView(), $this->getViewData())
            ->layout($this->getLayout(), [
                'livewire' => $this,
                'maxContentWidth' => $this->getMaxContentWidth(),
                ...$this->getLayoutData(),
            ]);
    }

    public function getView(): string
    {
        return static::$view;
    }

    public function getLayout(): string
    {
        return static::$layout;
    }

    public function getHeading(): string | Htmlable
    {
        return $this->heading ?? $this->getTitle();
    }

    public function getSubheading(): string | Htmlable | null
    {
        return $this->subheading;
    }

    public function getTitle(): string | Htmlable
    {
        return static::$title ?? (string) str(class_basename(static::class))
            ->kebab()
            ->replace('-', ' ')
            ->title();
    }

    public function getMaxContentWidth(): MaxWidth | string | null
    {
        return $this->maxContentWidth;
    }

    /**
     * @return array<mixed>
     */
    public function getExtraBodyAttributes(): array
    {
        return $this->extraBodyAttributes;
    }

    /**
     * @return array<string, mixed>
     */
    protected function getLayoutData(): array
    {
        return [];
    }

    /**
     * @return array<string, mixed>
     */
    protected function getViewData(): array
    {
        return [];
    }

    protected function onValidationError(ValidationException $exception): void
    {
        if (! static::$reportValidationErrorUsing) {
            return;
        }

        (static::$reportValidationErrorUsing)($exception);
    }

    protected function halt(bool $shouldRollbackDatabaseTransaction = false): void
    {
        throw (new Halt)->rollBackDatabaseTransaction($shouldRollbackDatabaseTransaction);
    }

    protected function callHook(string $hook): void
    {
        if (! method_exists($this, $hook)) {
            return;
        }

        $this->{$hook}();
    }

    public static function stickyFormActions(bool $condition = true): void
    {
        static::$formActionsAreSticky = $condition;
    }

    public static function alignFormActionsStart(): void
    {
        static::$formActionsAlignment = Alignment::Start;
    }

    public static function alignFormActionsCenter(): void
    {
        static::$formActionsAlignment = Alignment::Center;
    }

    public static function alignFormActionsEnd(): void
    {
        static::$formActionsAlignment = Alignment::End;
    }

    /**
     * @deprecated Use `alignFormActionsStart()` instead
     */
    public static function alignFormActionsLeft(): void
    {
        static::alignFormActionsStart();
    }

    /**
     * @deprecated Use `alignFormActionsEnd()` instead
     */
    public static function alignFormActionsRight(): void
    {
        static::alignFormActionsEnd();
    }

    public function getFormActionsAlignment(): string | Alignment
    {
        return static::$formActionsAlignment;
    }

    public function areFormActionsSticky(): bool
    {
        return static::$formActionsAreSticky;
    }

    public function hasInlineLabels(): bool
    {
        return static::$hasInlineLabels;
    }

    public static function formActionsAlignment(string | Alignment $alignment): void
    {
        static::$formActionsAlignment = $alignment;
    }

    public static function inlineLabels(bool $condition = true): void
    {
        static::$hasInlineLabels = $condition;
    }

    /**
     * @return array<string>
     */
    public function getRenderHookScopes(): array
    {
        return [static::class];
    }
}
