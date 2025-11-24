<x-admin-layout 
    title="Editar Mascota | Sistema Veterinaria"
    :breadcrumbs="[
        ['name' => 'Dashboard', 'href' => route('admin.dashboard')],
        ['name' => 'Mascotas', 'href' => route('admin.pets.index')],
        ['name' => 'Editar'],
    ]">
    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('admin.pets.update', $pet) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <x-label for="name" value="Nombre de la Mascota" />
                <x-input 
                    id="name" 
                    name="name" 
                    type="text" 
                    class="mt-1 block w-full" 
                    placeholder="Ej: Max, Luna, etc."
                    value="{{ old('name', $pet->name) }}" 
                    required 
                    autofocus
                />
                @error('name')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <x-label for="species" value="Especie" />
                <x-input 
                    id="species" 
                    name="species" 
                    type="text" 
                    class="mt-1 block w-full" 
                    placeholder="Ej: Perro, Gato, etc."
                    value="{{ old('species', $pet->species) }}" 
                    required
                />
                @error('species')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <x-label for="breed" value="Raza" />
                <x-input 
                    id="breed" 
                    name="breed" 
                    type="text" 
                    class="mt-1 block w-full" 
                    placeholder="Ej: Labrador, Persa, etc."
                    value="{{ old('breed', $pet->breed) }}"
                />
                @error('breed')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <x-label for="age" value="Edad (años)" />
                <x-input 
                    id="age" 
                    name="age" 
                    type="number" 
                    class="mt-1 block w-full" 
                    placeholder="Ej: 3"
                    value="{{ old('age', $pet->age) }}"
                    min="0"
                />
                @error('age')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <x-label for="owner_id" value="Dueño" />
                <select 
                    id="owner_id" 
                    name="owner_id" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    required
                >
                    <option value="">Seleccione un dueño</option>
                    @foreach($owners as $owner)
                        <option value="{{ $owner->id }}" {{ old('owner_id', $pet->owner_id) == $owner->id ? 'selected' : '' }}>
                            {{ $owner->name }} ({{ $owner->email }})
                        </option>
                    @endforeach
                </select>
                @error('owner_id')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <x-label for="notes" value="Notas" />
                <textarea 
                    id="notes" 
                    name="notes" 
                    rows="3"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    placeholder="Información adicional sobre la mascota..."
                >{{ old('notes', $pet->notes) }}</textarea>
                @error('notes')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end mt-4 space-x-3">
                <a href="{{ route('admin.pets.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Cancelar
                </a>
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Actualizar
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>

