<?php

namespace WellCMS\Actions;

use WellCMS\Actions\Contracts\HasLivewire;
use WellCMS\Notifications\Notification;
use WellCMS\Support\Exceptions\Cancel;
use WellCMS\Support\Exceptions\Halt;

abstract class MountableAction extends StaticAction implements HasLivewire
{
    use Concerns\BelongsToLivewire;
    use Concerns\CanBeMounted;
    use Concerns\CanNotify;
    use Concerns\CanOpenModal;
    use Concerns\CanRedirect;
    use Concerns\CanRequireConfirmation;
    use Concerns\CanUseDatabaseTransactions;
    use Concerns\HasExtraModalWindowAttributes;
    use Concerns\HasForm;
    use Concerns\HasInfolist;
    use Concerns\HasLifecycleHooks;
    use Concerns\HasParentActions;
    use Concerns\HasWizard;

    protected function setUp(): void
    {
        parent::setUp();

        $this->defaultView(static::BUTTON_VIEW);

        $this->failureNotification(fn (Notification $notification): Notification => $notification);
        $this->successNotification(fn (Notification $notification): Notification => $notification);
    }

    /**
     * @param  array<string, mixed>  $parameters
     */
    public function call(array $parameters = []): mixed
    {
        return $this->evaluate($this->getActionFunction(), $parameters);
    }

    public function cancel(bool $shouldRollBackDatabaseTransaction = false): void
    {
        throw (new Cancel)->rollBackDatabaseTransaction($shouldRollBackDatabaseTransaction);
    }

    public function halt(bool $shouldRollBackDatabaseTransaction = false): void
    {
        throw (new Halt)->rollBackDatabaseTransaction($shouldRollBackDatabaseTransaction);
    }

    /**
     * @deprecated Use `halt()` instead.
     */
    public function hold(): void
    {
        $this->halt();
    }

    public function success(): void
    {
        $this->sendSuccessNotification();
        $this->dispatchSuccessRedirect();
    }

    public function failure(): void
    {
        $this->sendFailureNotification();
        $this->dispatchFailureRedirect();
    }

    /**
     * @return array<mixed>
     */
    protected function resolveDefaultClosureDependencyForEvaluationByName(string $parameterName): array
    {
        return match ($parameterName) {
            'arguments' => [$this->getArguments()],
            'data' => [$this->getFormData()],
            'livewire' => [$this->getLivewire()],
            default => parent::resolveDefaultClosureDependencyForEvaluationByName($parameterName),
        };
    }
}
