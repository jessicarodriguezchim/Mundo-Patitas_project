

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detalle de Mascota') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    
                    <div class="mb-4">
                        <a href="{{ route('client.pets.index') }}" class="text-blue-600 hover:text-blue-900 mb-4 inline-block">
                            <i class="fa-solid fa-arrow-left mr-2"></i> Volver a mis mascotas
                        </a>
                    </div>

                    
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">{{ $pet->name }}</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-700 mb-4">Información Básica</h3>
                            <dl class="space-y-3">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Nombre</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $pet->name }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Especie</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $pet->species }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Raza</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $pet->breed ?? 'No especificada' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Edad</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $pet->age ? $pet->age . ' años' : 'No especificada' }}</dd>
                                </div>
                            </dl>
                        </div>

                        <div>
                            <h3 class="text-lg font-semibold text-gray-700 mb-4">Información del Dueño</h3>
                            <dl class="space-y-3">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Nombre</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $pet->owner->name }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Email</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $pet->owner->email }}</dd>
                                </div>
                                @if($pet->owner->phone)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Teléfono</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $pet->owner->phone }}</dd>
                                    </div>
                                @endif
                            </dl>
                        </div>
                    </div>

                    @if($pet->notes)
                        <div class="mt-6">
                            <h3 class="text-lg font-semibold text-gray-700 mb-2">Notas</h3>
                            <p class="text-sm text-gray-900 bg-gray-50 p-4 rounded-md">{{ $pet->notes }}</p>
                        </div>
                    @endif

                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <div class="text-sm text-gray-500">
                            <p>Registrado: {{ $pet->created_at->format('d/m/Y H:i') }}</p>
                            <p>Última actualización: {{ $pet->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
