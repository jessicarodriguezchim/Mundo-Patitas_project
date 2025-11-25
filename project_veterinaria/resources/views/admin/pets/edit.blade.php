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
                <x-label for="owner_search" value="Dueño" />
                <div class="relative mt-1">
                    <input 
                        type="text" 
                        id="owner_search" 
                        name="owner_search"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-pastel-aqua focus:ring-pastel-aqua input-pastel"
                        placeholder="Escribe el nombre, email o número de identificación del dueño..."
                        value="{{ old('owner_search', $pet->owner ? $pet->owner->name . ' (' . $pet->owner->email . ')' : '') }}"
                        autocomplete="off"
                        required
                    />
                    <input type="hidden" id="owner_id" name="owner_id" value="{{ old('owner_id', $pet->owner_id) }}" required>
                    <div id="owner_results" class="absolute z-10 w-full mt-1 bg-white border border-pastel-aqua/30 rounded-soft shadow-soft-lg hidden max-h-60 overflow-y-auto"></div>
                </div>
                <p class="mt-1 text-xs text-pastel-gray-text/70">Escribe al menos 2 caracteres para buscar</p>
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

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ownerSearch = document.getElementById('owner_search');
            const ownerId = document.getElementById('owner_id');
            const ownerResults = document.getElementById('owner_results');
            let searchTimeout;

            // Si hay un valor antiguo, cargar el usuario
            @if(old('owner_id'))
                const oldSearch = '{{ old("owner_search", $pet->owner ? $pet->owner->name . " (" . $pet->owner->email . ")" : "") }}';
                if (oldSearch) {
                    ownerSearch.value = oldSearch;
                }
            @elseif($pet->owner)
                ownerSearch.value = '{{ $pet->owner->name }} ({{ $pet->owner->email }})';
                ownerId.value = {{ $pet->owner_id }};
            @endif

            ownerSearch.addEventListener('input', function() {
                const query = this.value.trim();
                
                // Limpiar timeout anterior
                clearTimeout(searchTimeout);
                
                // Ocultar resultados si la búsqueda es muy corta
                if (query.length < 2) {
                    ownerResults.classList.add('hidden');
                    ownerId.value = '';
                    return;
                }

                // Esperar 300ms antes de buscar (debounce)
                searchTimeout = setTimeout(() => {
                    fetch(`{{ url('/api/users/search') }}?q=${encodeURIComponent(query)}`, {
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        ownerResults.innerHTML = '';
                        
                        if (data.length === 0) {
                            ownerResults.innerHTML = '<div class="p-3 text-sm text-pastel-gray-text">No se encontraron usuarios</div>';
                            ownerResults.classList.remove('hidden');
                            return;
                        }

                        data.forEach(user => {
                            const item = document.createElement('div');
                            item.className = 'p-3 hover:bg-pastel-aqua/20 cursor-pointer border-b border-pastel-aqua/10 last:border-b-0 transition-colors';
                            item.innerHTML = `
                                <div class="font-semibold text-pastel-gray-text">${user.name}</div>
                                <div class="text-xs text-pastel-gray-text/70">${user.email}</div>
                                ${user.id_number ? `<div class="text-xs text-pastel-aqua/80">ID: ${user.id_number}</div>` : ''}
                            `;
                            
                            item.addEventListener('click', function() {
                                ownerSearch.value = `${user.name} (${user.email})`;
                                ownerId.value = user.id;
                                ownerResults.classList.add('hidden');
                            });
                            
                            ownerResults.appendChild(item);
                        });
                        
                        ownerResults.classList.remove('hidden');
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        ownerResults.classList.add('hidden');
                    });
                }, 300);
            });

            // Ocultar resultados al hacer clic fuera
            document.addEventListener('click', function(event) {
                if (!ownerSearch.contains(event.target) && !ownerResults.contains(event.target)) {
                    ownerResults.classList.add('hidden');
                }
            });

            // Limpiar cuando se borra el campo
            ownerSearch.addEventListener('keydown', function(e) {
                if (e.key === 'Backspace' && this.value.length === 0) {
                    ownerId.value = '';
                }
            });
        });
    </script>
    @endpush
</x-admin-layout>

