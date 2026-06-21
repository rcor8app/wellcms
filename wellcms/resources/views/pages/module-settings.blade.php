<x-wellcms::page>
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <x-wellcms::header
                title="Керування модулями"
                description="Увімкніть, вимкніть, створіть або видаліть модулі системи для зміни доступного функціоналу."
            />
            
            <button
                type="button"
                wire:click="$set('showCreateModal', true)"
                class="inline-flex items-center justify-center gap-x-1.5 rounded-lg bg-primary-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600"
            >
                <x-heroicon-o-plus class="-ml-0.5 h-5 w-5" />
                Створити модуль
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($this->getModules() as $key => $module)
                <div class="relative flex flex-col justify-between rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
                    <div class="flex items-start justify-between gap-x-4">
                        <div class="space-y-1">
                            <div class="flex items-center gap-2">
                                <h3 class="text-base font-semibold leading-6 text-gray-950 dark:text-white">
                                    {{ $module['name'] }}
                                </h3>
                                @if($module['can_delete'] ?? true)
                                    <span class="inline-flex items-center rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-550/10 dark:bg-gray-400/10 dark:text-gray-400">Кастомний</span>
                                @endif
                            </div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                {{ $module['description'] }}
                            </p>
                        </div>
                        
                        <div class="flex items-center gap-3">
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

                            @if($module['can_delete'] ?? true)
                                <button
                                    type="button"
                                    wire:click="deleteModule('{{ $key }}')"
                                    wire:confirm="Ви впевнені, що хочете видалити цей модуль?"
                                    class="text-gray-400 hover:text-danger-600 transition"
                                    title="Видалити модуль"
                                >
                                    <x-heroicon-o-trash class="h-5 w-5" />
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if($showCreateModal)
            <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-950/40 backdrop-blur-sm">
                <div class="w-full max-w-md rounded-xl bg-white p-6 shadow-xl ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
                    <h2 class="text-lg font-semibold text-gray-950 dark:text-white mb-4">Створення нового модуля</h2>
                    
                    <form wire:submit="createModule" class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Назва модуля</label>
                            <input type="text" wire:model="newModuleName" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-primary-500 focus:outline-none dark:bg-gray-800 dark:border-gray-700 dark:text-white" required placeholder="Наприклад: Галерея">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Опис модуля</label>
                            <textarea wire:model="newModuleDescription" rows="3" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-primary-500 focus:outline-none dark:bg-gray-800 dark:border-gray-700 dark:text-white" placeholder="Опис функціоналу..." required></textarea>
                        </div>

                        <div class="flex justify-end gap-x-3 pt-2">
                            <button type="button" wire:click="$set('showCreateModal', false)" class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-850">
                                Скасувати
                            </button>
                            <button type="submit" class="rounded-lg bg-primary-600 px-4 py-2 text-sm font-medium text-white hover:bg-primary-500">
                                Створити
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    </div>
</x-wellcms::page>
