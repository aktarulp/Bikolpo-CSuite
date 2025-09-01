<div class="space-y-8">
    <!-- Password Policy -->
    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Password Policy</h3>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Configure password requirements and expiration rules</p>
        </div>
        <div class="p-6 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="min_password_length" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Minimum Password Length</label>
                    <input type="number" id="min_password_length" value="8" min="6" max="32" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white">
                </div>
                <div>
                    <label for="password_expiry_days" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Password Expiry (days)</label>
                    <input type="number" id="password_expiry_days" value="90" min="30" max="365" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white">
                </div>
            </div>
            
            <div>
                <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-3">Password Requirements</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <label class="flex items-center">
                        <input type="checkbox" class="rounded border-gray-300 text-primaryGreen shadow-sm focus:border-primaryGreen focus:ring-primaryGreen dark:border-gray-600 dark:bg-gray-700" checked>
                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Require uppercase letters</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" class="rounded border-gray-300 text-primaryGreen shadow-sm focus:border-primaryGreen focus:ring-primaryGreen dark:border-gray-600 dark:bg-gray-700" checked>
                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Require lowercase letters</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" class="rounded border-gray-300 text-primaryGreen shadow-sm focus:border-primaryGreen focus:ring-primaryGreen dark:border-gray-600 dark:bg-gray-700" checked>
                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Require numbers</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" class="rounded border-gray-300 text-primaryGreen shadow-sm focus:border-primaryGreen focus:ring-primaryGreen dark:border-gray-600 dark:bg-gray-700" checked>
                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Require special characters</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" class="rounded border-gray-300 text-primaryGreen shadow-sm focus:border-primaryGreen focus:ring-primaryGreen dark:border-gray-600 dark:bg-gray-700" checked>
                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Prevent common passwords</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" class="rounded border-gray-300 text-primaryGreen shadow-sm focus:border-primaryGreen focus:ring-primaryGreen dark:border-gray-600 dark:bg-gray-700">
                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Prevent password reuse</span>
                    </label>
                </div>
            </div>
        </div>
    </div>

    <!-- Two-Factor Authentication -->
    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Two-Factor Authentication</h3>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Enhance security with additional authentication methods</p>
        </div>
        <div class="p-6 space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <h4 class="text-sm font-medium text-gray-900 dark:text-white">Enable 2FA for all users</h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Require two-factor authentication for enhanced security</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" class="sr-only peer" checked>
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primaryGreen/20 dark:peer-focus:ring-primaryGreen/30 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-primaryGreen"></div>
                </label>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-3">2FA Methods</h4>
                    <div class="space-y-3">
                        <label class="flex items-center">
                            <input type="checkbox" class="rounded border-gray-300 text-primaryGreen shadow-sm focus:border-primaryGreen focus:ring-primaryGreen dark:border-gray-600 dark:bg-gray-700" checked>
                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Authenticator apps (TOTP)</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" class="rounded border-gray-300 text-primaryGreen shadow-sm focus:border-primaryGreen focus:ring-primaryGreen dark:border-gray-600 dark:bg-gray-700" checked>
                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">SMS verification</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" class="rounded border-gray-300 text-primaryGreen shadow-sm focus:border-primaryGreen focus:ring-primaryGreen dark:border-gray-600 dark:bg-gray-700">
                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Email verification</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" class="rounded border-gray-300 text-primaryGreen shadow-sm focus:border-primaryGreen focus:ring-primaryGreen dark:border-gray-600 dark:bg-gray-700">
                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Hardware security keys</span>
                        </label>
                    </div>
                </div>
                
                <div>
                    <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-3">2FA Settings</h4>
                    <div class="space-y-4">
                        <div>
                            <label for="totp_window" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">TOTP Window (seconds)</label>
                            <input type="number" id="totp_window" value="30" min="15" max="60" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label for="backup_codes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Backup Codes Count</label>
                            <input type="number" id="backup_codes" value="10" min="5" max="20" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Session Management -->
    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Session Management</h3>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Control user sessions and access patterns</p>
        </div>
        <div class="p-6 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label for="session_timeout" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Session Timeout (minutes)</label>
                    <input type="number" id="session_timeout" value="30" min="5" max="480" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white">
                </div>
                <div>
                    <label for="max_sessions" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Max Concurrent Sessions</label>
                    <input type="number" id="max_sessions" value="3" min="1" max="10" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white">
                </div>
                <div>
                    <label for="idle_timeout" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Idle Timeout (minutes)</label>
                    <input type="number" id="idle_timeout" value="15" min="5" max="120" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white">
                </div>
            </div>
            
            <div class="space-y-3">
                <label class="flex items-center">
                    <input type="checkbox" class="rounded border-gray-300 text-primaryGreen shadow-sm focus:border-primaryGreen focus:ring-primaryGreen dark:border-gray-600 dark:bg-gray-700" checked>
                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Force logout on password change</span>
                </label>
                <label class="flex items-center">
                    <input type="checkbox" class="rounded border-gray-300 text-primaryGreen shadow-sm focus:border-primaryGreen focus:ring-primaryGreen dark:border-gray-600 dark:bg-gray-700" checked>
                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Force logout on role change</span>
                </label>
                <label class="flex items-center">
                    <input type="checkbox" class="rounded border-gray-300 text-primaryGreen shadow-sm focus:border-primaryGreen focus:ring-primaryGreen dark:border-gray-600 dark:bg-gray-700">
                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Remember user preferences</span>
                </label>
            </div>
        </div>
    </div>

    <!-- IP Security -->
    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">IP Security</h3>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Control access based on IP addresses and locations</p>
        </div>
        <div class="p-6 space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <h4 class="text-sm font-medium text-gray-900 dark:text-white">Enable IP restrictions</h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Restrict access to specific IP addresses or ranges</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primaryGreen/20 dark:peer-focus:ring-primaryGreen/30 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-primaryGreen"></div>
                </label>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="allowed_ips" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Allowed IP Addresses</label>
                    <textarea id="allowed_ips" rows="4" placeholder="Enter IP addresses or ranges (one per line)&#10;Example:&#10;192.168.1.0/24&#10;10.0.0.1" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white"></textarea>
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Leave empty to allow all IPs</p>
                </div>
                
                <div>
                    <label for="blocked_ips" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Blocked IP Addresses</label>
                    <textarea id="blocked_ips" rows="4" placeholder="Enter IP addresses to block (one per line)&#10;Example:&#10;203.0.113.1&#10;198.51.100.0/24" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white"></textarea>
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">These IPs will be blocked regardless of allowed list</p>
                </div>
            </div>
            
            <div class="space-y-3">
                <label class="flex items-center">
                    <input type="checkbox" class="rounded border-gray-300 text-primaryGreen shadow-sm focus:border-primaryGreen focus:ring-primaryGreen dark:border-gray-600 dark:bg-gray-700">
                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Block known malicious IPs</span>
                </label>
                <label class="flex items-center">
                    <input type="checkbox" class="rounded border-gray-300 text-primaryGreen shadow-sm focus:border-primaryGreen focus:ring-primaryGreen dark:border-gray-600 dark:bg-gray-700">
                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Enable geolocation blocking</span>
                </label>
                <label class="flex items-center">
                    <input type="checkbox" class="rounded border-gray-300 text-primaryGreen shadow-sm focus:border-primaryGreen focus:ring-primaryGreen dark:border-gray-600 dark:bg-gray-700">
                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Log IP access attempts</span>
                </label>
            </div>
        </div>
    </div>

    <!-- Security Monitoring -->
    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Security Monitoring</h3>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Monitor and respond to security events</p>
        </div>
        <div class="p-6 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-3">Event Logging</h4>
                    <div class="space-y-3">
                        <label class="flex items-center">
                            <input type="checkbox" class="rounded border-gray-300 text-primaryGreen shadow-sm focus:border-primaryGreen focus:ring-primaryGreen dark:border-gray-600 dark:bg-gray-700" checked>
                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Log failed login attempts</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" class="rounded border-gray-300 text-primaryGreen shadow-sm focus:border-primaryGreen focus:ring-primaryGreen dark:border-gray-600 dark:bg-gray-700" checked>
                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Log permission changes</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" class="rounded border-gray-300 text-primaryGreen shadow-sm focus:border-primaryGreen focus:ring-primaryGreen dark:border-gray-600 dark:bg-gray-700" checked>
                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Log data exports</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" class="rounded border-gray-300 text-primaryGreen shadow-sm focus:border-primaryGreen focus:ring-primaryGreen dark:border-gray-600 dark:bg-gray-700">
                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Log file access</span>
                        </label>
                    </div>
                </div>
                
                <div>
                    <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-3">Alert Settings</h4>
                    <div class="space-y-3">
                        <label class="flex items-center">
                            <input type="checkbox" class="rounded border-gray-300 text-primaryGreen shadow-sm focus:border-primaryGreen focus:ring-primaryGreen dark:border-gray-600 dark:bg-gray-700" checked>
                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Alert on multiple failed logins</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" class="rounded border-gray-300 text-primaryGreen shadow-sm focus:border-primaryGreen focus:ring-primaryGreen dark:border-gray-600 dark:bg-gray-700" checked>
                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Alert on suspicious IP access</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" class="rounded border-gray-300 text-primaryGreen shadow-sm focus:border-primaryGreen focus:ring-primaryGreen dark:border-gray-600 dark:bg-gray-700">
                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Alert on data export</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" class="rounded border-gray-300 text-primaryGreen shadow-sm focus:border-primaryGreen focus:ring-primaryGreen dark:border-gray-600 dark:bg-gray-700">
                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Alert on admin actions</span>
                        </label>
                    </div>
                </div>
            </div>
            
            <div>
                <label for="alert_threshold" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Failed Login Alert Threshold</label>
                <input type="number" id="alert_threshold" value="5" min="1" max="20" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-primaryGreen focus:border-primaryGreen dark:bg-gray-700 dark:text-white">
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Number of failed attempts before alerting</p>
            </div>
        </div>
    </div>

    <!-- Data Protection -->
    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Data Protection</h3>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Configure data encryption and privacy settings</p>
        </div>
        <div class="p-6 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-3">Encryption</h4>
                    <div class="space-y-3">
                        <label class="flex items-center">
                            <input type="checkbox" class="rounded border-gray-300 text-primaryGreen shadow-sm focus:border-primaryGreen focus:ring-primaryGreen dark:border-gray-600 dark:bg-gray-700" checked>
                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Encrypt sensitive data at rest</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" class="rounded border-gray-300 text-primaryGreen shadow-sm focus:border-primaryGreen focus:ring-primaryGreen dark:border-gray-600 dark:bg-gray-700" checked>
                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Encrypt data in transit (HTTPS)</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" class="rounded border-gray-300 text-primaryGreen shadow-sm focus:border-primaryGreen focus:ring-primaryGreen dark:border-gray-600 dark:bg-gray-700">
                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Encrypt backup files</span>
                        </label>
                    </div>
                </div>
                
                <div>
                    <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-3">Privacy</h4>
                    <div class="space-y-3">
                        <label class="flex items-center">
                            <input type="checkbox" class="rounded border-gray-300 text-primaryGreen shadow-sm focus:border-primaryGreen focus:ring-primaryGreen dark:border-gray-600 dark:bg-gray-700" checked>
                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Anonymize user data in logs</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" class="rounded border-gray-300 text-primaryGreen shadow-sm focus:border-primaryGreen focus:ring-primaryGreen dark:border-gray-600 dark:bg-gray-700">
                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Enable data retention policies</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" class="rounded border-gray-300 text-primaryGreen shadow-sm focus:border-primaryGreen focus:ring-primaryGreen dark:border-gray-600 dark:bg-gray-700">
                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">GDPR compliance mode</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Save Button -->
    <div class="flex justify-end">
        <button type="button" onclick="saveSecuritySettings()" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg shadow-sm text-white bg-primaryGreen hover:bg-primaryGreen/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primaryGreen transition-colors duration-200">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            Save Security Settings
        </button>
    </div>
</div>

<script>
function saveSecuritySettings() {
    // Collect all security settings
    const securitySettings = {
        password: {
            minLength: document.getElementById('min_password_length').value,
            expiryDays: document.getElementById('password_expiry_days').value,
            requirements: {
                uppercase: document.querySelectorAll('input[type="checkbox"]')[0].checked,
                lowercase: document.querySelectorAll('input[type="checkbox"]')[1].checked,
                numbers: document.querySelectorAll('input[type="checkbox"]')[2].checked,
                special: document.querySelectorAll('input[type="checkbox"]')[3].checked,
                common: document.querySelectorAll('input[type="checkbox"]')[4].checked,
                reuse: document.querySelectorAll('input[type="checkbox"]')[5].checked
            }
        },
        twoFactor: {
            enabled: document.querySelectorAll('input[type="checkbox"]')[6].checked,
            methods: {
                totp: document.querySelectorAll('input[type="checkbox"]')[7].checked,
                sms: document.querySelectorAll('input[type="checkbox"]')[8].checked,
                email: document.querySelectorAll('input[type="checkbox"]')[9].checked,
                hardware: document.querySelectorAll('input[type="checkbox"]')[10].checked
            },
            settings: {
                totpWindow: document.getElementById('totp_window').value,
                backupCodes: document.getElementById('backup_codes').value
            }
        },
        session: {
            timeout: document.getElementById('session_timeout').value,
            maxSessions: document.getElementById('max_sessions').value,
            idleTimeout: document.getElementById('idle_timeout').value,
            forceLogout: {
                passwordChange: document.querySelectorAll('input[type="checkbox"]')[11].checked,
                roleChange: document.querySelectorAll('input[type="checkbox"]')[12].checked,
                rememberPreferences: document.querySelectorAll('input[type="checkbox"]')[13].checked
            }
        },
        ipSecurity: {
            enabled: document.querySelectorAll('input[type="checkbox"]')[14].checked,
            allowedIPs: document.getElementById('allowed_ips').value,
            blockedIPs: document.getElementById('blocked_ips').value,
            features: {
                blockMalicious: document.querySelectorAll('input[type="checkbox"]')[15].checked,
                geolocation: document.querySelectorAll('input[type="checkbox"]')[16].checked,
                logAccess: document.querySelectorAll('input[type="checkbox"]')[17].checked
            }
        },
        monitoring: {
            logging: {
                failedLogins: document.querySelectorAll('input[type="checkbox"]')[18].checked,
                permissionChanges: document.querySelectorAll('input[type="checkbox"]')[19].checked,
                dataExports: document.querySelectorAll('input[type="checkbox"]')[20].checked,
                fileAccess: document.querySelectorAll('input[type="checkbox"]')[21].checked
            },
            alerts: {
                failedLogins: document.querySelectorAll('input[type="checkbox"]')[22].checked,
                suspiciousIP: document.querySelectorAll('input[type="checkbox"]')[23].checked,
                dataExport: document.querySelectorAll('input[type="checkbox"]')[24].checked,
                adminActions: document.querySelectorAll('input[type="checkbox"]')[25].checked
            },
            threshold: document.getElementById('alert_threshold').value
        },
        dataProtection: {
            encryption: {
                atRest: document.querySelectorAll('input[type="checkbox"]')[26].checked,
                inTransit: document.querySelectorAll('input[type="checkbox"]')[27].checked,
                backups: document.querySelectorAll('input[type="checkbox"]')[28].checked
            },
            privacy: {
                anonymizeLogs: document.querySelectorAll('input[type="checkbox"]')[29].checked,
                retentionPolicies: document.querySelectorAll('input[type="checkbox"]')[30].checked,
                gdprCompliance: document.querySelectorAll('input[type="checkbox"]')[31].checked
            }
        }
    };
    
    // Here you would typically send the data to your backend
    console.log('Saving security settings:', securitySettings);
    
    // Show success message
    if (typeof showToast === 'function') {
        showToast('Security settings saved successfully!', 'success');
    }
}
</script>
