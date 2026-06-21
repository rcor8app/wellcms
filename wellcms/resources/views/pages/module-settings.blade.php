<x-wellcms-panels::page>
    <div class="space-y-6">
        <x-wellcms-panels::header
            title="Керування модулями"
            description="Увімкніть або вимкніть модулі системи для зміни доступного функціоналу."
        />

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($this->getModules() as $key => $module)
                <div class="relative flex flex-col justify-between rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
                    <div class="flex items-start justify-between gap-x-4">
                        <div class="space-y-1">
                            <h3 class="text-base font-semibold leading-6 text-gray-950 dark:text-white">
                                {{ $module['name'] }}
                            </h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                {{ $module['description'] }}
                            </p>
                        </div>
                        
                        <button
                            type="button"
                            wire:click="toggleModule('{{ $key }}')"
                            @class([
                                'relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none',
                                'bg-primary-600' => $this->isModuleActive($key),
                                'bg-gray-200 dark:bg-gray-700' => !$this->isModuleActive($key),
                            ])
                        >
                            <span
                                @class([
                                    'pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out',
                                    'translate-x-5' => $this->isModuleActive($key),
                                    'translate-x-0' => !$this->isModuleActive($key),
                                ])
                            ></span>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-wellcms-panels::page>
