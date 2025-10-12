<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="{{url('/')}}">
                <x-application-logo class="w-20 h-20" />
            </a>
        </x-slot>

        <div class="mb-4">
            {{ __('messages.password_msg') }}
        </div>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <!-- Password -->
            <div>
                <x-label for="password" :value="__('messages.password')" />

                <x-input id="password" class="block mt-1"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />
            </div>

            <div class="d-flex justify-content-end align-items-center mt-4">
                <x-button>
                    {{ __('messages.confirm') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
