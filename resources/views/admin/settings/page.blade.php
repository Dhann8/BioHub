@extends('layout.admin')
@section('content')

<div class="flex min-h-screen bg-[#F8FAFC]" x-data="{ currentTab: 'general' }">
    @include('components.admin.sidebar')
    
    <div class="flex-1 flex flex-col min-h-screen overflow-x-hidden">
        
        <!-- TOP HEADER -->
        <header id="header" class="bg-white border-b border-gray-100 px-6 py-4 flex items-center justify-between gap-4 sticky top-0 z-10">
            <div>
                <h1 class="text-xl font-bold text-gray-800">Settings</h1>
            </div>
            
            <div class="flex items-center gap-3">
                <button type="submit" form="settingsForm" class="flex items-center gap-2 bg-[#1E4D2B] hover:bg-[#163a20] text-white text-sm font-semibold px-6 py-2 rounded-xl transition-colors shadow-sm cursor-pointer active:scale-95">
                    <i class="fa-solid fa-save text-xs"></i> Save Changes
                </button>
            </div>
        </header>

        <!-- CONTENT BODY -->
        <main class="flex-1 px-6 py-8">
            <!-- Alert Messages -->
            @if(session('success'))
            <div class="max-w-4xl mx-auto mb-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-medium px-4 py-3 rounded-xl flex items-center gap-2 shadow-sm">
                <i class="fa-solid fa-circle-check text-emerald-600 text-base"></i>
                <span>{{ session('success') }}</span>
            </div>
            @endif

            <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="grid grid-cols-1 md:grid-cols-4 min-h-[500px]">
                    
                    <!-- Settings Navigation -->
                    <div class="border-r border-gray-100 p-6 space-y-1 bg-gray-50/30">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4 px-2">System</p>
                        <a href="#" @click.prevent="currentTab = 'general'" 
                           :class="currentTab === 'general' ? 'bg-white shadow-sm border border-gray-200 text-[#1E4D2B] font-semibold' : 'border border-transparent text-gray-600 hover:bg-gray-50'"
                           class="block px-3 py-2.5 rounded-xl text-sm transition">
                            <i class="fa-solid fa-sliders w-5" :class="currentTab === 'general' ? 'text-[#1E4D2B]' : 'text-gray-400'"></i> General
                        </a>
                        <a href="#" @click.prevent="currentTab = 'appearance'" 
                           :class="currentTab === 'appearance' ? 'bg-white shadow-sm border border-gray-200 text-[#1E4D2B] font-semibold' : 'border border-transparent text-gray-600 hover:bg-gray-50'"
                           class="block px-3 py-2.5 rounded-xl text-sm transition mt-1">
                            <i class="fa-solid fa-palette w-5" :class="currentTab === 'appearance' ? 'text-[#1E4D2B]' : 'text-gray-400'"></i> Appearance
                        </a>
                        
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4 px-2 mt-8">Advanced</p>
                        <a href="#" @click.prevent="currentTab = 'security'" 
                           :class="currentTab === 'security' ? 'bg-white shadow-sm border border-gray-200 text-[#1E4D2B] font-semibold' : 'border border-transparent text-gray-600 hover:bg-gray-50'"
                           class="block px-3 py-2.5 rounded-xl text-sm transition">
                            <i class="fa-solid fa-shield-halved w-5" :class="currentTab === 'security' ? 'text-[#1E4D2B]' : 'text-gray-400'"></i> Security
                        </a>
                    </div>
                    
                    <!-- Settings Form Area -->
                    <div class="md:col-span-3 p-8">
                        <form id="settingsForm" method="POST" action="{{ route('admin.settings.update') }}" class="space-y-6">
                            @csrf
                            
                            <!-- TAB: GENERAL -->
                            <div x-show="currentTab === 'general'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                                <h2 class="text-lg font-bold text-gray-900 mb-6">General Settings</h2>
                                
                                <div class="space-y-6">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Application Name</label>
                                        <input type="text" name="settings[app_name]" value="{{ $settings['app_name'] ?? 'Nusantara BioHub' }}" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#1E4D2B]/30 focus:border-[#1E4D2B] transition-all text-sm text-gray-800">
                                        <p class="text-xs text-gray-500 mt-1.5">This name will be displayed on the header and emails.</p>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Support Email</label>
                                        <input type="email" name="settings[support_email]" value="{{ $settings['support_email'] ?? 'support@biohub.id' }}" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#1E4D2B]/30 focus:border-[#1E4D2B] transition-all text-sm text-gray-800">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Contact Phone</label>
                                        <input type="text" name="settings[support_phone]" value="{{ $settings['support_phone'] ?? '+62 812-3456-7890' }}" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#1E4D2B]/30 focus:border-[#1E4D2B] transition-all text-sm text-gray-800">
                                    </div>
                                </div>
                            </div>

                            <!-- TAB: APPEARANCE -->
                            <div x-show="currentTab === 'appearance'" style="display: none;" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                                <h2 class="text-lg font-bold text-gray-900 mb-6">Appearance</h2>
                                
                                <div class="space-y-6">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Theme Mode</label>
                                        <select name="settings[theme]" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#1E4D2B]/30 focus:border-[#1E4D2B] transition-all text-sm text-gray-800">
                                            <option value="light" {{ ($settings['theme'] ?? 'light') == 'light' ? 'selected' : '' }}>Light Theme</option>
                                            <option value="dark" {{ ($settings['theme'] ?? '') == 'dark' ? 'selected' : '' }}>Dark Theme</option>
                                            <option value="system" {{ ($settings['theme'] ?? '') == 'system' ? 'selected' : '' }}>System Default</option>
                                        </select>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Dashboard Layout</label>
                                        <select name="settings[layout]" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#1E4D2B]/30 focus:border-[#1E4D2B] transition-all text-sm text-gray-800">
                                            <option value="expanded" {{ ($settings['layout'] ?? 'expanded') == 'expanded' ? 'selected' : '' }}>Sidebar Expanded</option>
                                            <option value="collapsed" {{ ($settings['layout'] ?? '') == 'collapsed' ? 'selected' : '' }}>Sidebar Collapsed</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- TAB: SECURITY -->
                            <div x-show="currentTab === 'security'" style="display: none;" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                                <h2 class="text-lg font-bold text-gray-900 mb-6">Security & Access</h2>
                                
                                <div class="space-y-6">
                                    <div class="flex items-center justify-between p-4 bg-gray-50 border border-gray-200 rounded-xl">
                                        <div>
                                            <h4 class="text-sm font-bold text-gray-900">Maintenance Mode</h4>
                                            <p class="text-xs text-gray-500 mt-1">Disable access to the public facing website.</p>
                                        </div>
                                        <label class="relative inline-flex items-center cursor-pointer">
                                          <input type="hidden" name="settings[maintenance_mode]" value="0">
                                          <input type="checkbox" name="settings[maintenance_mode]" value="1" class="sr-only peer" {{ ($settings['maintenance_mode'] ?? '0') == '1' ? 'checked' : '' }}>
                                          <div class="w-11 h-6 bg-gray-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-red-600"></div>
                                        </label>
                                    </div>
                                    
                                    <div class="flex items-center justify-between p-4 bg-gray-50 border border-gray-200 rounded-xl">
                                        <div>
                                            <h4 class="text-sm font-bold text-gray-900">Allow Public Registration</h4>
                                            <p class="text-xs text-gray-500 mt-1">Enable or disable new user signups.</p>
                                        </div>
                                        <label class="relative inline-flex items-center cursor-pointer">
                                          <input type="hidden" name="settings[allow_registration]" value="0">
                                          <input type="checkbox" name="settings[allow_registration]" value="1" class="sr-only peer" {{ ($settings['allow_registration'] ?? '1') == '1' ? 'checked' : '' }}>
                                          <div class="w-11 h-6 bg-gray-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#1E4D2B]"></div>
                                        </label>
                                    </div>
                                    
                                    <div class="flex items-center justify-between p-4 bg-gray-50 border border-gray-200 rounded-xl">
                                        <div>
                                            <h4 class="text-sm font-bold text-gray-900">Auto-Approve Community Data</h4>
                                            <p class="text-xs text-gray-500 mt-1">Automatically approve entries from trusted users.</p>
                                        </div>
                                        <label class="relative inline-flex items-center cursor-pointer">
                                          <input type="hidden" name="settings[auto_approve]" value="0">
                                          <input type="checkbox" name="settings[auto_approve]" value="1" class="sr-only peer" {{ ($settings['auto_approve'] ?? '0') == '1' ? 'checked' : '' }}>
                                          <div class="w-11 h-6 bg-gray-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#1E4D2B]"></div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                        </form>
                    </div>
                    
                </div>
            </div>
        </main>
        
    </div>
</div>

@endsection
