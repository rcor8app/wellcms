import NotificationComponentAlpinePlugin from './components/notification'
import {
    Action as NotificationAction,
    ActionGroup as NotificationActionGroup,
    Notification,
} from './Notification'

window.WellCMSNotificationAction = NotificationAction
window.WellCMSNotificationActionGroup = NotificationActionGroup
window.WellCMSNotification = Notification

document.addEventListener('alpine:init', () => {
    window.Alpine.plugin(NotificationComponentAlpinePlugin)
})
