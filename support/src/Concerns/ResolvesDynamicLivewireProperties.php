<?php

namespace WellCMS\Support\Concerns;

use WellCMS\Actions\Contracts\HasActions;
use WellCMS\Forms\Contracts\HasForms;
use WellCMS\Infolists\Contracts\HasInfolists;
use Livewire\Exceptions\PropertyNotFoundException;

trait ResolvesDynamicLivewireProperties
{
    /**
     * @param  string  $property
     *
     * @throws PropertyNotFoundException
     */
    public function __get($property): mixed
    {
        try {
            return parent::__get($property);
        } catch (PropertyNotFoundException $exception) {
        }

        if (
            $this instanceof HasForms &&
            (! $this->isCachingForms()) &&
            $form = $this->getForm($property)
        ) {
            return $form;
        }

        if (
            $this instanceof HasInfolists &&
            $infolist = $this->getInfolist($property)
        ) {
            return $infolist;
        }

        if (
            $this instanceof HasActions &&
            $action = $this->getAction($property)
        ) {
            return $action;
        }

        throw $exception;
    }
}
