<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-pastel-gray-text leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-soft-lg rounded-soft-lg border border-pastel-aqua/20">
                <x-welcome />
            </div>
        </div>
    </div>
</x-app-layout>
