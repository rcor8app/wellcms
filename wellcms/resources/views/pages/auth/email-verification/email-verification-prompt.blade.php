<x-wellcms-panels::page.simple>
    <p class="text-center text-sm text-gray-500 dark:text-gray-400">
        {{
            __('wellcms-panels::pages/auth/email-verification/email-verification-prompt.messages.notification_sent', [
                'email' => wellcms()->auth()->user()->getEmailForVerification(),
            ])
        }}
    </p>

    <p class="text-center text-sm text-gray-500 dark:text-gray-400">
        {{ __('wellcms-panels::pages/auth/email-verification/email-verification-prompt.messages.notification_not_received') }}

        {{ $this->resendNotificationAction }}
    </p>
</x-wellcms-panels::page.simple>
