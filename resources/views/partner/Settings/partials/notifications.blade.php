<div class="space-y-8">
    <!-- Email Notifications -->
    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Email Notifications</h3>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Configure email notification preferences and settings</p>
        </div>
        <div class="p-6 space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <h4 class="text-sm font-medium text-gray-900 dark:text-white">Enable email notifications</h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Send notifications via email</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" class="sr-only peer" checked>
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primaryGreen/20 dark:peer-focus:ring-primaryGreen/30 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-primaryGreen"></div>
                </label>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="from_email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">From Email Address</label>
                    <input type="email" id="from_email" value="noreply@example.com" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white">
                </div>
                <div>
                    <label for="reply_to_email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Reply-To Email</label>
                    <input type="email" id="reply_to_email" value="support@example.com" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white">
                </div>
            </div>
            
            <div>
                <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-3">Email Types</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <label class="flex items-center">
                        <input type="checkbox" class="rounded border-gray-300 text-primaryGreen shadow-sm focus:border-primaryGreen focus:ring-primaryGreen dark:border-gray-600 dark:bg-gray-700" checked>
                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Account notifications</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" class="rounded border-gray-300 text-primaryGreen shadow-sm focus:border-primaryGreen focus:ring-primaryGreen dark:border-gray-600 dark:bg-gray-700" checked>
                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Security alerts</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" class="rounded border-gray-300 text-primaryGreen shadow-sm focus:border-primaryGreen focus:ring-primaryGreen dark:border-gray-600 dark:bg-gray-700" checked>
                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">System updates</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" class="rounded border-gray-300 text-primaryGreen shadow-sm focus:border-primaryGreen focus:ring-primaryGreen dark:border-gray-600 dark:bg-gray-700">
                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Marketing emails</span>
                    </label>
                </div>
            </div>
        </div>
    </div>

    <!-- SMS Notifications -->
    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">SMS Notifications</h3>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Configure SMS notification settings and providers</p>
        </div>
        <div class="p-6 space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <h4 class="text-sm font-medium text-gray-900 dark:text-white">Enable SMS notifications</h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Send notifications via SMS</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primaryGreen/20 dark:peer-focus:ring-primaryGreen/30 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-primaryGreen"></div>
                </label>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="sms_provider" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">SMS Provider</label>
                    <select id="sms_provider" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white">
                        <option value="twilio">Twilio</option>
                        <option value="nexmo">Nexmo (Vonage)</option>
                        <option value="aws_sns">AWS SNS</option>
                        <option value="custom">Custom Provider</option>
                    </select>
                </div>
                <div>
                    <label for="sms_sender_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Sender ID</label>
                    <input type="text" id="sms_sender_id" value="EDUAPP" maxlength="11" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white">
                </div>
            </div>
            
            <div>
                <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-3">SMS Types</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <label class="flex items-center">
                        <input type="checkbox" class="rounded border-gray-300 text-primaryGreen shadow-sm focus:border-primaryGreen focus:ring-primaryGreen dark:border-gray-600 dark:bg-gray-700">
                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Security alerts</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" class="rounded border-gray-300 text-primaryGreen shadow-sm focus:border-primaryGreen focus:ring-primaryGreen dark:border-gray-600 dark:bg-gray-700">
                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Emergency notifications</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" class="rounded border-gray-300 text-primaryGreen shadow-sm focus:border-primaryGreen focus:ring-primaryGreen dark:border-gray-600 dark:bg-gray-700">
                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Exam reminders</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" class="rounded border-gray-300 text-primaryGreen shadow-sm focus:border-primaryGreen focus:ring-primaryGreen dark:border-gray-600 dark:bg-gray-700">
                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Payment confirmations</span>
                    </label>
                </div>
            </div>
        </div>
    </div>

    <!-- In-App Notifications -->
    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">In-App Notifications</h3>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Configure notification preferences within the application</p>
        </div>
        <div class="p-6 space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <h4 class="text-sm font-medium text-gray-900 dark:text-white">Enable in-app notifications</h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Show notifications within the application</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" class="sr-only peer" checked>
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primaryGreen/20 dark:peer-focus:ring-primaryGreen/30 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-primaryGreen"></div>
                </label>
            </div>
            
            <div>
                <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-3">Notification Types</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <label class="flex items-center">
                        <input type="checkbox" class="rounded border-gray-300 text-primaryGreen shadow-sm focus:border-primaryGreen focus:ring-primaryGreen dark:border-gray-600 dark:bg-gray-700" checked>
                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">System updates</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" class="rounded border-gray-300 text-primaryGreen shadow-sm focus:border-primaryGreen focus:ring-primaryGreen dark:border-gray-600 dark:bg-gray-700" checked>
                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">New messages</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" class="rounded border-gray-300 text-primaryGreen shadow-sm focus:border-primaryGreen focus:ring-primaryGreen dark:border-gray-600 dark:bg-gray-700" checked>
                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Task reminders</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" class="rounded border-gray-300 text-primaryGreen shadow-sm focus:border-primaryGreen focus:ring-primaryGreen dark:border-gray-600 dark:bg-gray-700" checked>
                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Achievement badges</span>
                    </label>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="notification_sound" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Notification Sound</label>
                    <select id="notification_sound" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white">
                        <option value="default">Default</option>
                        <option value="chime">Chime</option>
                        <option value="bell">Bell</option>
                        <option value="none">No Sound</option>
                    </select>
                </div>
                <div>
                    <label for="notification_position" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Notification Position</label>
                    <select id="notification_position" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white">
                        <option value="top-right">Top Right</option>
                        <option value="top-left">Top Left</option>
                        <option value="bottom-right">Bottom Right</option>
                        <option value="bottom-left">Bottom Left</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Notification Schedule -->
    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Notification Schedule</h3>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Configure when notifications can be sent</p>
        </div>
        <div class="p-6 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="quiet_hours_start" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Quiet Hours Start</label>
                    <input type="time" id="quiet_hours_start" value="22:00" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white">
                </div>
                <div>
                    <label for="quiet_hours_end" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Quiet Hours End</label>
                    <input type="time" id="quiet_hours_end" value="08:00" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white">
                </div>
            </div>
            
            <div class="space-y-3">
                <label class="flex items-center">
                    <input type="checkbox" class="rounded border-gray-300 text-primaryGreen shadow-sm focus:border-primaryGreen focus:ring-primaryGreen dark:border-gray-600 dark:bg-gray-700" checked>
                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Respect quiet hours for non-urgent notifications</span>
                </label>
                <label class="flex items-center">
                    <input type="checkbox" class="rounded border-gray-300 text-primaryGreen shadow-sm focus:border-primaryGreen focus:ring-primaryGreen dark:border-gray-600 dark:bg-gray-700" checked>
                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Allow urgent notifications during quiet hours</span>
                </label>
                <label class="flex items-center">
                    <input type="checkbox" class="rounded border-gray-300 text-primaryGreen shadow-sm focus:border-primaryGreen focus:ring-primaryGreen dark:border-gray-600 dark:bg-gray-700">
                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Send digest notifications instead of individual ones</span>
                </label>
            </div>
            
            <div>
                <label for="timezone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Notification Timezone</label>
                <select id="timezone" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white">
                    <option value="Asia/Dhaka" selected>Asia/Dhaka (GMT+6)</option>
                    <option value="Asia/Kolkata">Asia/Kolkata (GMT+5:30)</option>
                    <option value="Asia/Karachi">Asia/Karachi (GMT+5)</option>
                    <option value="Asia/Kathmandu">Asia/Kathmandu (GMT+5:45)</option>
                    <option value="Asia/Colombo">Asia/Colombo (GMT+5:30)</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Notification Channels -->
    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Notification Channels</h3>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Configure which channels receive specific notification types</p>
        </div>
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Notification Type</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">SMS</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">In-App</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">Account Security</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <input type="checkbox" class="rounded border-gray-300 text-primaryGreen shadow-sm focus:border-primaryGreen focus:ring-primaryGreen dark:border-gray-600 dark:bg-gray-700" checked>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <input type="checkbox" class="rounded border-gray-300 text-primaryGreen shadow-sm focus:border-primaryGreen focus:ring-primaryGreen dark:border-gray-600 dark:bg-gray-700" checked>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <input type="checkbox" class="rounded border-gray-300 text-primaryGreen shadow-sm focus:border-primaryGreen focus:ring-primaryGreen dark:border-gray-600 dark:bg-gray-700" checked>
                            </td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">System Updates</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <input type="checkbox" class="rounded border-gray-300 text-primaryGreen shadow-sm focus:border-primaryGreen focus:ring-primaryGreen dark:border-gray-600 dark:bg-gray-700" checked>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <input type="checkbox" class="rounded border-gray-300 text-primaryGreen shadow-sm focus:border-primaryGreen focus:ring-primaryGreen dark:border-gray-600 dark:bg-gray-700">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <input type="checkbox" class="rounded border-gray-300 text-primaryGreen shadow-sm focus:border-primaryGreen focus:ring-primaryGreen dark:border-gray-600 dark:bg-gray-700" checked>
                            </td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">New Messages</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <input type="checkbox" class="rounded border-gray-300 text-primaryGreen shadow-sm focus:border-primaryGreen focus:ring-primaryGreen dark:border-gray-600 dark:bg-gray-700">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <input type="checkbox" class="rounded border-gray-300 text-primaryGreen shadow-sm focus:border-primaryGreen focus:ring-primaryGreen dark:border-gray-600 dark:bg-gray-700">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <input type="checkbox" class="rounded border-gray-300 text-primaryGreen shadow-sm focus:border-primaryGreen focus:ring-primaryGreen dark:border-gray-600 dark:bg-gray-700" checked>
                            </td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">Task Reminders</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <input type="checkbox" class="rounded border-gray-300 text-primaryGreen shadow-sm focus:border-primaryGreen focus:ring-primaryGreen dark:border-gray-600 dark:bg-gray-700">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <input type="checkbox" class="rounded border-gray-300 text-primaryGreen shadow-sm focus:border-primaryGreen focus:ring-primaryGreen dark:border-gray-600 dark:bg-gray-700">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <input type="checkbox" class="rounded border-gray-300 text-primaryGreen shadow-sm focus:border-primaryGreen focus:ring-primaryGreen dark:border-gray-600 dark:bg-gray-700" checked>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Notification Templates -->
    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Notification Templates</h3>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Customize notification message templates</p>
        </div>
        <div class="p-6 space-y-6">
            <div>
                <label for="welcome_template" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Welcome Message Template</label>
                <textarea id="welcome_template" rows="3" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white">Welcome to {institution_name}! We're excited to have you on board. Your account has been successfully created.</textarea>
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Available variables: {user_name}, {institution_name}, {date}</p>
            </div>
            
            <div>
                <label for="security_template" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Security Alert Template</label>
                <textarea id="security_template" rows="3" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white">Security Alert: {event_type} detected for your account at {time}. If this wasn't you, please contact support immediately.</textarea>
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Available variables: {event_type}, {time}, {ip_address}, {location}</p>
            </div>
            
            <div>
                <label for="reminder_template" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Reminder Template</label>
                <textarea id="reminder_template" rows="3" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white">Reminder: {task_name} is due on {due_date}. Please complete it before the deadline.</textarea>
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Available variables: {task_name}, {due_date}, {priority}</p>
            </div>
        </div>
    </div>

    <!-- Save Button -->
    <div class="flex justify-end">
        <button type="button" onclick="saveNotificationSettings()" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg shadow-sm text-white bg-primaryGreen hover:bg-primaryGreen/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primaryGreen transition-colors duration-200">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            Save Notification Settings
        </button>
    </div>
</div>

<script>
function saveNotificationSettings() {
    // Collect all notification settings
    const notificationSettings = {
        email: {
            enabled: document.querySelectorAll('input[type="checkbox"]')[0].checked,
            fromEmail: document.getElementById('from_email').value,
            replyToEmail: document.getElementById('reply_to_email').value,
            types: {
                account: document.querySelectorAll('input[type="checkbox"]')[1].checked,
                security: document.querySelectorAll('input[type="checkbox"]')[2].checked,
                system: document.querySelectorAll('input[type="checkbox"]')[3].checked,
                marketing: document.querySelectorAll('input[type="checkbox"]')[4].checked
            }
        },
        sms: {
            enabled: document.querySelectorAll('input[type="checkbox"]')[5].checked,
            provider: document.getElementById('sms_provider').value,
            senderId: document.getElementById('sms_sender_id').value,
            types: {
                security: document.querySelectorAll('input[type="checkbox"]')[6].checked,
                emergency: document.querySelectorAll('input[type="checkbox"]')[7].checked,
                exam: document.querySelectorAll('input[type="checkbox"]')[8].checked,
                payment: document.querySelectorAll('input[type="checkbox"]')[9].checked
            }
        },
        inApp: {
            enabled: document.querySelectorAll('input[type="checkbox"]')[10].checked,
            types: {
                system: document.querySelectorAll('input[type="checkbox"]')[11].checked,
                messages: document.querySelectorAll('input[type="checkbox"]')[12].checked,
                tasks: document.querySelectorAll('input[type="checkbox"]')[13].checked,
                achievements: document.querySelectorAll('input[type="checkbox"]')[14].checked
            },
            sound: document.getElementById('notification_sound').value,
            position: document.getElementById('notification_position').value
        },
        schedule: {
            quietHoursStart: document.getElementById('quiet_hours_start').value,
            quietHoursEnd: document.getElementById('quiet_hours_end').value,
            respectQuietHours: document.querySelectorAll('input[type="checkbox"]')[15].checked,
            allowUrgent: document.querySelectorAll('input[type="checkbox"]')[16].checked,
            sendDigest: document.querySelectorAll('input[type="checkbox"]')[17].checked,
            timezone: document.getElementById('timezone').value
        },
        channels: {
            accountSecurity: {
                email: document.querySelectorAll('input[type="checkbox"]')[18].checked,
                sms: document.querySelectorAll('input[type="checkbox"]')[19].checked,
                inApp: document.querySelectorAll('input[type="checkbox"]')[20].checked
            },
            systemUpdates: {
                email: document.querySelectorAll('input[type="checkbox"]')[21].checked,
                sms: document.querySelectorAll('input[type="checkbox"]')[22].checked,
                inApp: document.querySelectorAll('input[type="checkbox"]')[23].checked
            },
            newMessages: {
                email: document.querySelectorAll('input[type="checkbox"]')[24].checked,
                sms: document.querySelectorAll('input[type="checkbox"]')[25].checked,
                inApp: document.querySelectorAll('input[type="checkbox"]')[26].checked
            },
            taskReminders: {
                email: document.querySelectorAll('input[type="checkbox"]')[27].checked,
                sms: document.querySelectorAll('input[type="checkbox"]')[28].checked,
                inApp: document.querySelectorAll('input[type="checkbox"]')[29].checked
            }
        },
        templates: {
            welcome: document.getElementById('welcome_template').value,
            security: document.getElementById('security_template').value,
            reminder: document.getElementById('reminder_template').value
        }
    };
    
    // Here you would typically send the data to your backend
    console.log('Saving notification settings:', notificationSettings);
    
    // Show success message
    if (typeof showToast === 'function') {
        showToast('Notification settings saved successfully!', 'success');
    }
}
</script>
