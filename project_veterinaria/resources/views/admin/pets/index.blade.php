<x-admin-layout 
    title="Mascotas | Sistema Veterinaria"
    :breadcrumbs="[
        ['name' => 'Dashboard', 'href' => route('admin.dashboard')],
        ['name' => 'Mascotas'],
    ]">
    <x-slot name="actions">
        <x-wire-button href="{{ route('admin.pets.create') }}" blue>
            <i class="fa-solid fa-plus"></i>
            <span class="ml-1">Nueva Mascota</span>
        </x-wire-button>
    </x-slot>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Especie</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Raza</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Edad</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dueño</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($pets as $pet)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $pet->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $pet->species }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $pet->breed ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $pet->age ?? 'N/A' }} años</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $pet->owner->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('admin.pets.show', $pet) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.pets.edit', $pet) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                    <i class="fa-solid fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.pets.destroy', $pet) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de eliminar esta mascota?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                No hay mascotas registradas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $pets->links() }}
        </div>
    </div>
</x-admin-layout>

