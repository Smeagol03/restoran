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
                <x-input 
                    label="Email address" 
                    name="email" 
                    type="email" 
                    autocomplete="email" 
                    required 
                    :value="old('email')" 
                    placeholder="name@company.com"
                />

                <x-input 
                    label="Password" 
                    name="password" 
                    type="password" 
                    autocomplete="current-password" 
                    required 
                    placeholder="••••••••"
                />

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <x-checkbox id="remember" name="remember" class="h-4 w-4 rounded border-zinc-300 text-orange-600 focus:ring-orange-500" />
                        <x-label for="remember" value="Remember me" class="ml-2 mb-0" />
                    </div>
                </div>

                <div>
                    <x-button type="submit" variant="primary" class="w-full justify-center py-2.5">
                        Sign in
                    </x-button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
