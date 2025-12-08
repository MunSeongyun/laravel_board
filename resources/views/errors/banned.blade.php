<x-guest-layout>
    <div class="mb-4 text-center">
        <div class="flex justify-center mb-4">
            <svg class="w-16 h-16 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
        </div>

        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200">
            {{ __('Account Suspended') }}
        </h2>
        <p class="mt-2 text-gray-600 dark:text-gray-400">
            {{ __('Your account has been suspended by the administrator.') }}
        </p>
    </div>

    @php
        $ban = auth()->user()->latestBan();
    @endphp

    @if($ban)
        <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4 mb-6">
            <div class="mb-2">
                <span class="font-bold text-red-800 dark:text-red-400">{{ __('Reason') }}:</span>
                <span class="text-gray-700 dark:text-gray-300 ml-2">
                    {{ $ban->reason ?? __('No reason provided') }}
                </span>
            </div>
            
            <div>
                <span class="font-bold text-red-800 dark:text-red-400">{{ __('Period') }}:</span>
                <span class="text-gray-700 dark:text-gray-300 ml-2">
                    @if($ban->banned_until)
                        {{ __('Until :date', ['date' => $ban->banned_until->format('Y-m-d H:i')]) }}
                        <span class="text-sm text-gray-500">
                            ({{ $ban->banned_until->diffForHumans() }} {{ __('lifted') }})
                        </span>
                    @else
                        <span class="font-bold text-red-600">{{ __('Permanent Ban') }}</span>
                    @endif
                </span>
            </div>
        </div>
    @endif

    <div class="flex justify-center mt-6">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
</x-guest-layout>