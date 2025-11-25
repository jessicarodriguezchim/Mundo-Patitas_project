<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mi Perfil') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-soft-lg rounded-soft-lg border border-pastel-aqua/20">
                <div class="p-6">
                    <h2 class="text-2xl font-bold text-pastel-gray-text mb-6">Información Personal</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <dl class="space-y-4">
                                <div>
                                    <dt class="text-sm font-medium text-pastel-gray-text">Nombre</dt>
                                    <dd class="mt-1 text-sm text-pastel-gray-text font-medium">{{ $user->name }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-pastel-gray-text">Email</dt>
                                    <dd class="mt-1 text-sm text-pastel-gray-text font-medium">{{ $user->email }}</dd>
                                </div>
                                @if($user->id_number)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Número de Identificación</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $user->id_number }}</dd>
                                    </div>
                                @endif
                            </dl>
                        </div>

                        <div>
                            <dl class="space-y-4">
                                @if($user->phone)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Teléfono</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $user->phone }}</dd>
                                    </div>
                                @endif
                                @if($user->address)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Dirección</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $user->address }}</dd>
                                    </div>
                                @endif
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Rol</dt>
                                    <dd class="mt-1">
                                        <span class="badge-pastel-aqua">
                                            {{ $user->roles->first()->name ?? 'Sin rol' }}
                                        </span>
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Estado</dt>
                                    <dd class="mt-1">
                                        @if($user->is_active)
                                            <span class="badge-pastel-aqua">
                                                Activo
                                            </span>
                                        @else
                                            <span class="badge-pastel-pink">
                                                Inactivo
                                            </span>
                                        @endif
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    <div class="mt-6 pt-6 border-t border-pastel-aqua/20">
                        <div class="flex justify-between items-center">
                            <div class="text-sm text-pastel-gray-text">
                                <p>Miembro desde: {{ $user->created_at->format('d/m/Y') }}</p>
                            </div>
                            <a href="{{ route('profile.show') }}" class="inline-flex items-center px-4 py-2 bg-pastel-aqua border border-transparent rounded-soft font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#8FD9D9] focus:outline-none focus:ring-2 focus:ring-pastel-aqua/50 focus:ring-offset-2 transition-all ease-in-out duration-200 shadow-soft hover:shadow-soft-lg">
                                Editar Perfil
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
