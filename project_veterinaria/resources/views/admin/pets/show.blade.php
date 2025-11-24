<x-admin-layout 
    title="Detalle de Mascota | Sistema Veterinaria"
    :breadcrumbs="[
        ['name' => 'Dashboard', 'href' => route('admin.dashboard')],
        ['name' => 'Mascotas', 'href' => route('admin.pets.index')],
        ['name' => 'Detalle'],
    ]">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="mb-4 flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-800">{{ $pet->name }}</h2>
            <div class="space-x-2">
                <a href="{{ route('admin.pets.edit', $pet) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <i class="fa-solid fa-edit mr-2"></i> Editar
                </a>
                <a href="{{ route('admin.pets.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Volver
                </a>
            </div>
        </div>

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
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Teléfono</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $pet->owner->phone ?? 'No especificado' }}</dd>
                    </div>
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
</x-admin-layout>

