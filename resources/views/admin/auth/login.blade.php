<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.head')
</head>
<body class="min-h-screen bg-zinc-50 dark:bg-zinc-950 font-sans antialiased flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md text-center">
        <a href="/" class="inline-flex items-center gap-2 font-bold text-2xl text-zinc-900 dark:text-white mb-6">
            <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-zinc-900 dark:bg-white">
                <x-app-logo-icon class="size-6 fill-current text-white dark:text-zinc-900" />
            </span>
            {{ config('app.name') }} Admin
        </a>
        <h2 class="text-3xl font-bold tracking-tight text-zinc-900 dark:text-white">Sign in to your account</h2>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white dark:bg-zinc-900 py-8 px-4 shadow sm:rounded-xl sm:px-10 border border-zinc-200 dark:border-zinc-800">
            <form class="space-y-6" action="{{ route('admin.login') }}" method="POST">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Email address</label>
                    <div class="mt-1">
                        <input id="email" name="email" type="email" autocomplete="email" required value="{{ old('email') }}" class="block w-full appearance-none rounded-md border border-zinc-300 dark:border-zinc-700 px-3 py-2 placeholder-zinc-400 dark:bg-zinc-800 dark:text-white shadow-sm focus:border-orange-500 focus:outline-none focus:ring-orange-500 sm:text-sm">
                    </div>
                    @error('email')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Password</label>
                    <div class="mt-1">
                        <input id="password" name="password" type="password" autocomplete="current-password" required class="block w-full appearance-none rounded-md border border-zinc-300 dark:border-zinc-700 px-3 py-2 placeholder-zinc-400 dark:bg-zinc-800 dark:text-white shadow-sm focus:border-orange-500 focus:outline-none focus:ring-orange-500 sm:text-sm">
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember" name="remember" type="checkbox" class="h-4 w-4 rounded border-zinc-300 text-orange-600 focus:ring-orange-500">
                        <label for="remember" class="ml-2 block text-sm text-zinc-900 dark:text-zinc-300">Remember me</label>
                    </div>
                </div>

                <div>
                    <button type="submit" class="flex w-full justify-center rounded-md border border-transparent bg-orange-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2">
                        Sign in
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
