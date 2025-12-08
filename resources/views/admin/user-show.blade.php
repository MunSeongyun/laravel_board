<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('User Details') }}: {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">{{ __('Basic Information') }}</h3>
                    <div class="grid grid-cols-1 gap-4 text-sm text-gray-600 dark:text-gray-400">
                        <div><strong class="text-gray-800 dark:text-gray-200">ID:</strong> {{ $user->id }}</div>
                        <div><strong class="text-gray-800 dark:text-gray-200">{{ __('Name') }}:</strong> {{ $user->name }}</div>
                        <div><strong class="text-gray-800 dark:text-gray-200">{{ __('Email') }}:</strong> {{ $user->email }}</div>
                        <div><strong class="text-gray-800 dark:text-gray-200">{{ __('Joined') }}:</strong> {{ $user->created_at->format('Y-m-d H:i:s') }}</div>
                        <div>
                            <strong class="text-gray-800 dark:text-gray-200">{{ __('Status') }}:</strong>
                            @if($user->trashed())
                                <span class="text-red-600 font-bold">{{ __('Deleted Account') }}</span>
                            @elseif($user->isBanned())
                                <span class="text-red-600 font-bold">{{ __('Suspended') }}</span>
                            @else
                                <span class="text-green-600 font-bold">{{ __('Active') }}</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="mt-6 flex gap-4">
                        <a href="{{ route('users.edit', $user) }}">
                            <x-secondary-button>{{ __('Edit Info') }}</x-secondary-button>
                        </a>
                        <a href="{{ route('users.index') }}">
                            <x-secondary-button>{{ __('Back to List') }}</x-secondary-button>
                        </a>
                    </div>
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">{{ __('Account Suspension') }}</h3>
                    
                    @if($user->isBanned())
                        <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-md p-4">
                            <p class="text-red-800 dark:text-red-300 font-bold mb-2">
                                {{ __('This user is currently banned.') }}
                            </p>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                                {{ __('Reason') }}: {{ $user->latestBan()->reason }}<br>
                                {{ __('Expires') }}: {{ $user->latestBan()->banned_until ? $user->latestBan()->banned_until->format('Y-m-d H:i') : __('Permanent') }}
                            </p>
                            
                            <form action="{{ route('users.unban', $user) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <x-primary-button class="bg-red-600 hover:bg-red-500">
                                    {{ __('Unban User') }}
                                </x-primary-button>
                            </form>
                        </div>
                    @else
                        <form action="{{ route('users.ban', $user) }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <x-input-label for="reason" :value="__('Ban Reason')" />
                                <x-text-input id="reason" name="reason" type="text" class="mt-1 block w-full" required />
                                <x-input-error :messages="$errors->get('reason')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="period" :value="__('Ban Duration')" />
                                <select name="period" id="period" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                    <option value="3">3 {{ __('Days') }}</option>
                                    <option value="7">7 {{ __('Days') }}</option>
                                    <option value="30">30 {{ __('Days') }}</option>
                                    <option value="0">{{ __('Permanent') }}</option>
                                </select>
                            </div>

                            <x-danger-button>
                                {{ __('Ban User') }}
                            </x-danger-button>
                        </form>
                    @endif
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">{{ __('Delete Account') }}</h3>
                    
                    @if($user->trashed())
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                            {{ __('This account is currently deleted.') }}
                        </p>
                        @else
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                            {{ __('Delete this user account. The user will not be able to login.') }}
                        </p>
                        <form action="{{ route('users.destroy', $user) }}" method="POST" onsubmit="return confirm('{{ __('Are you sure?') }}');">
                            @csrf
                            @method('DELETE')
                            <x-danger-button>
                                {{ __('Delete Account') }}
                            </x-danger-button>
                        </form>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>