<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <a href="{{ route('posts.trashed') }}" class="block p-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150 ease-in-out border-l-4 border-red-500">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-red-100 dark:bg-red-900 text-red-500 dark:text-red-300">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <div class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                {{ __('Trashed Posts') }}
                            </div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                삭제된 게시글을 복구하거나 완전히 삭제합니다.
                            </div>
                        </div>
                    </div>
                </a>

                <a href="{{ route('users.index') }}" class="block p-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150 ease-in-out border-l-4 border-blue-500">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900 text-blue-500 dark:text-blue-300">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <div class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                {{ __('Management User') }}
                            </div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                회원 목록을 조회하고 권한을 관리합니다.
                            </div>
                        </div>
                    </div>
                </a>

            </div>
        </div>
    </div>
</x-app-layout>