@extends('system-admin.system-admin-layout')

@section('title', 'Subscription Overview - System Admin')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <!-- Header -->
    <div class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
        <div class="px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Subscription Overview & Analytics</h1>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Comprehensive subscription analytics and insights</p>
                </div>
                <div class="mt-4 sm:mt-0 flex space-x-3">
                    <button onclick="alert('Export analytics functionality will be implemented')" 
                            class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Export Report
                    </button>
                    <button onclick="alert('Refresh analytics functionality will be implemented')" 
                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Refresh Data
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Navigation Tabs -->
        <div class="px-4 sm:px-6 lg:px-8">
            <nav class="flex space-x-8" aria-label="Tabs">
                <a href="{{ route('system-admin.subscription-plans') }}" 
                   class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm {{ request()->routeIs('system-admin.subscription-plans') ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300' }}">
                    Plans & Pricing
                </a>
                <a href="{{ route('system-admin.plan-features') }}" 
                   class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm {{ request()->routeIs('system-admin.plan-features*') ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300' }}">
                    Plan Features
                </a>
                <a href="{{ route('system-admin.subscription-overview') }}" 
                   class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm {{ request()->routeIs('system-admin.subscription-overview') ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300' }}">
                    Overview & Analytics
                </a>
                <a href="{{ route('system-admin.subscription-usage') }}" 
                   class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm {{ request()->routeIs('system-admin.subscription-usage') ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300' }}">
                    Usage Tracking
                </a>
                <a href="{{ route('system-admin.payment-methods') }}" 
                   class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm {{ request()->routeIs('system-admin.payment-methods*') ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300' }}">
                    Payment Methods
                </a>
                <a href="{{ route('system-admin.subscription-billing') }}" 
                   class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm {{ request()->routeIs('system-admin.subscription-billing') ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300' }}">
                    Billing & Payments
                </a>
            </nav>
        </div>
    </div>

    <!-- Key Metrics -->
    <div class="px-4 sm:px-6 lg:px-8 py-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Revenue -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 border-l-4 border-green-500">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Revenue</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">৳45,000</p>
                        <p class="text-sm text-green-600 dark:text-green-400">+12.5% from last month</p>
                    </div>
                </div>
            </div>

            <!-- Active Subscriptions -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 border-l-4 border-blue-500">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Active Subscriptions</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">27</p>
                        <p class="text-sm text-blue-600 dark:text-blue-400">+3 new this month</p>
                    </div>
                </div>
            </div>

            <!-- Monthly Recurring Revenue -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 border-l-4 border-purple-500">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Monthly Recurring Revenue</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">৳15,000</p>
                        <p class="text-sm text-purple-600 dark:text-purple-400">+8.2% from last month</p>
                    </div>
                </div>
            </div>

            <!-- Churn Rate -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 border-l-4 border-red-500">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-red-100 dark:bg-red-900 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Churn Rate</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">3.2%</p>
                        <p class="text-sm text-red-600 dark:text-red-400">-0.5% from last month</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Revenue Chart -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Revenue Trend</h3>
                    <div class="flex space-x-2">
                        <button class="px-3 py-1 text-xs font-medium text-blue-600 bg-blue-100 dark:bg-blue-900 rounded-full">6M</button>
                        <button class="px-3 py-1 text-xs font-medium text-gray-600 bg-gray-100 dark:bg-gray-700 rounded-full">1Y</button>
                    </div>
                </div>
                <div class="h-64">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>

            <!-- Subscription Distribution -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Plan Distribution</h3>
                <div class="h-64">
                    <canvas id="planDistributionChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Detailed Analytics -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <!-- Top Performing Plans -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Top Performing Plans</h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-blue-500 rounded-full mr-3"></div>
                            <span class="text-sm font-medium text-gray-900 dark:text-white">Basic Plan</span>
                        </div>
                        <div class="text-right">
                            <div class="text-sm font-bold text-gray-900 dark:text-white">8 subscribers</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">৳20,000 revenue</div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-purple-500 rounded-full mr-3"></div>
                            <span class="text-sm font-medium text-gray-900 dark:text-white">Premium Plan</span>
                        </div>
                        <div class="text-right">
                            <div class="text-sm font-bold text-gray-900 dark:text-white">5 subscribers</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">৳25,000 revenue</div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-emerald-500 rounded-full mr-3"></div>
                            <span class="text-sm font-medium text-gray-900 dark:text-white">Enterprise Plan</span>
                        </div>
                        <div class="text-right">
                            <div class="text-sm font-bold text-gray-900 dark:text-white">2 subscribers</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">৳20,000 revenue</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Subscriptions -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Recent Subscriptions</h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between py-2 border-b border-gray-200 dark:border-gray-700">
                        <div>
                            <p class="text-sm font-medium text-gray-900 dark:text-white">Smart Learn Coaching</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Premium Plan</p>
                        </div>
                        <span class="text-xs text-green-600 dark:text-green-400">৳5,000</span>
                    </div>
                    <div class="flex items-center justify-between py-2 border-b border-gray-200 dark:border-gray-700">
                        <div>
                            <p class="text-sm font-medium text-gray-900 dark:text-white">EduTech Center</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Basic Plan</p>
                        </div>
                        <span class="text-xs text-green-600 dark:text-green-400">৳2,500</span>
                    </div>
                    <div class="flex items-center justify-between py-2 border-b border-gray-200 dark:border-gray-700">
                        <div>
                            <p class="text-sm font-medium text-gray-900 dark:text-white">Future Academy</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Enterprise Plan</p>
                        </div>
                        <span class="text-xs text-green-600 dark:text-green-400">৳10,000</span>
                    </div>
                </div>
            </div>

            <!-- Subscription Health -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Subscription Health</h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Active Subscriptions</span>
                        <span class="text-sm font-bold text-green-600 dark:text-green-400">27</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Trial Subscriptions</span>
                        <span class="text-sm font-bold text-blue-600 dark:text-blue-400">5</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Expired Subscriptions</span>
                        <span class="text-sm font-bold text-red-600 dark:text-red-400">2</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Cancelled Subscriptions</span>
                        <span class="text-sm font-bold text-gray-600 dark:text-gray-400">1</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Subscription Table -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">All Subscriptions</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Partner</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Plan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Start Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Expires</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-full bg-gray-300 dark:bg-gray-600 flex items-center justify-center">
                                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">SL</span>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">Smart Learn Coaching</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">smartlearn@example.com</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300">
                                    Premium
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                                    Active
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">৳5,000</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">Jan 15, 2024</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">Feb 15, 2024</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">View</button>
                            </td>
                        </tr>
                        <!-- More rows... -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Revenue Chart
    const revenueCtx = document.getElementById('revenueChart');
    if (revenueCtx) {
        new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Revenue',
                    data: [12000, 15000, 18000, 22000, 25000, 30000],
                    borderColor: 'rgb(34, 197, 94)',
                    backgroundColor: 'rgba(34, 197, 94, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)'
                        }
                    },
                    x: {
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)'
                        }
                    }
                }
            }
        });
    }

    // Plan Distribution Chart
    const planCtx = document.getElementById('planDistributionChart');
    if (planCtx) {
        new Chart(planCtx, {
            type: 'doughnut',
            data: {
                labels: ['Free', 'Basic', 'Premium', 'Enterprise'],
                datasets: [{
                    data: [12, 8, 5, 2],
                    backgroundColor: [
                        'rgb(107, 114, 128)',
                        'rgb(59, 130, 246)',
                        'rgb(147, 51, 234)',
                        'rgb(16, 185, 129)'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    }
});
</script>
@endpush

@endsection
