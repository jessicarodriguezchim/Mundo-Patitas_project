

<x-admin-layout 
    title="Editar Usuario | Mundo Patitas"
    :breadcrumbs="[
        ['name' => 'Dashboard', 'href' => route('admin.dashboard')],
        ['name' => 'Usuarios', 'href' => route('admin.users.index')],
        ['name' => 'Editar Usuario'],
    ]">
    <div class="card-pastel">
        <h2 class="text-2xl font-bold text-pastel-aqua mb-6">Editar Usuario</h2>

        
        
        <form action="{{ route('admin.users.update', $user) }}" method="POST">
            @csrf
            
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <x-label for="name" value="Nombre Completo" />
                    <x-input 
                        id="name" 
                        name="name" 
                        type="text" 
                        class="mt-1 block w-full input-pastel" 
                        value="{{ old('name', $user->name) }}" 
                        required 
                        autofocus
                    />
                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <x-label for="email" value="Correo Electrónico" />
                    <x-input 
                        id="email" 
                        name="email" 
                        type="email" 
                        class="mt-1 block w-full input-pastel" 
                        value="{{ old('email', $user->email) }}" 
                        required
                    />
                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                
                <div>
                    
                    <x-label for="password" value="Nueva Contraseña (dejar vacío para no cambiar)" />
                    <x-input 
                        id="password" 
                        name="password" 
                        type="password" 
                        class="mt-1 block w-full input-pastel"
                    />
                    @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <x-label for="password_confirmation" value="Confirmar Nueva Contraseña" />
                    <x-input 
                        id="password_confirmation" 
                        name="password_confirmation" 
                        type="password" 
                        class="mt-1 block w-full input-pastel"
                    />
                </div>

                <div>
                    <x-label for="id_number" value="Número de Identificación" />
                    <x-input 
                        id="id_number" 
                        name="id_number" 
                        type="text" 
                        class="mt-1 block w-full input-pastel" 
                        value="{{ old('id_number', $user->id_number) }}"
                    />
                    @error('id_number')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <x-label for="phone" value="Teléfono" />
                    <x-input 
                        id="phone" 
                        name="phone" 
                        type="text" 
                        class="mt-1 block w-full input-pastel" 
                        value="{{ old('phone', $user->phone) }}"
                    />
                    @error('phone')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <x-label for="address" value="Dirección" />
                    <x-input 
                        id="address" 
                        name="address" 
                        type="text" 
                        class="mt-1 block w-full input-pastel" 
                        value="{{ old('address', $user->address) }}"
                    />
                    @error('address')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <x-label for="role" value="Rol" />
                    <select 
                        id="role" 
                        name="role" 
                        class="mt-1 block w-full input-pastel"
                        required
                    >
                        <option value="">Seleccione un rol</option>
                        @foreach($roles as $role)
                            
                            
                            
                            <option value="{{ $role->name }}" {{ old('role', $user->roles->first()?->name) == $role->name ? 'selected' : '' }}>
                                {{ ucfirst($role->name) }}
                            </option>
                        @endforeach
                    </select>
                    @error('role')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center">
                    <label class="flex items-center">
                        <input 
                            type="checkbox" 
                            name="is_active" 
                            value="1"
                            {{ old('is_active', $user->is_active) ? 'checked' : '' }}
                            class="rounded border-pastel-aqua/30 text-pastel-aqua focus:ring-pastel-aqua"
                        >
                        <span class="ml-2 text-pastel-gray-text">Usuario activo</span>
                    </label>
                </div>
            </div>

            <div class="flex justify-end mt-6 space-x-3">
                <a href="{{ route('admin.users.index') }}" class="inline-flex items-center px-4 py-2 bg-pastel-gray-text/20 border border-transparent rounded-soft font-semibold text-xs text-pastel-gray-text uppercase tracking-widest hover:bg-pastel-gray-text/30 focus:outline-none focus:ring-2 focus:ring-pastel-gray-text/30 focus:ring-offset-2 transition-all ease-in-out duration-200">
                    Cancelar
                </a>
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-pastel-aqua border border-transparent rounded-soft font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#8FD9D9] focus:outline-none focus:ring-2 focus:ring-pastel-aqua/50 focus:ring-offset-2 transition-all ease-in-out duration-200 shadow-soft hover:shadow-soft-lg">
                    <i class="fa-solid fa-save mr-2"></i>
                    Actualizar Usuario
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>
