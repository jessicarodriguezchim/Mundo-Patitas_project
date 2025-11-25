<x-admin-layout :breadcrumbs="[
    ['name' => 'Dashboard', 
    'href' => route('admin.dashboard')
],
]">
    <div class="space-y-6">
        <!-- Bienvenida Mundo Patitas -->
        <div class="card-pastel bg-gradient-to-br from-pastel-aqua/10 to-pastel-pink/10 border-2 border-pastel-aqua/30">
            <div class="flex flex-col md:flex-row items-center md:items-start gap-6">
                <!-- Icono o ilustración -->
                <div class="flex-shrink-0">
                    <div class="w-24 h-24 bg-pastel-aqua rounded-full flex items-center justify-center shadow-soft-lg">
                        <i class="fa-solid fa-paw text-5xl text-white"></i>
                    </div>
                </div>
                
                <!-- Mensaje de bienvenida -->
                <div class="flex-1 text-center md:text-left">
                    <h1 class="text-3xl md:text-4xl font-bold text-pastel-aqua mb-2">
                        ¡Bienvenido a Mundo Patitas! 🐾
                    </h1>
                    <p class="text-lg text-pastel-gray-text mb-4">
                        Hola <span class="font-semibold text-pastel-aqua">{{ $user->name }}</span>, 
                        estamos felices de tenerte aquí.
                    </p>
                    <p class="text-pastel-gray-text">
                        Sistema de gestión veterinaria diseñado con amor para cuidar de nuestras mascotas. 
                        Desde aquí podrás gestionar usuarios, roles y todas las mascotas registradas en nuestra clínica.
                    </p>
                </div>
            </div>
        </div>

        <!-- Estadísticas rápidas -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Total de Mascotas -->
            <div class="card-pastel bg-gradient-to-br from-pastel-aqua to-pastel-aqua/80 hover:shadow-soft-lg transition-all duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-white/80 text-sm font-medium mb-1">Total de Mascotas</p>
                        <p class="text-3xl font-bold text-white">{{ $stats['total_pets'] }}</p>
                    </div>
                    <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center">
                        <i class="fa-solid fa-paw text-2xl text-white"></i>
                    </div>
                </div>
            </div>

            <!-- Total de Usuarios -->
            <div class="card-pastel bg-gradient-to-br from-pastel-pink to-pastel-pink/80 hover:shadow-soft-lg transition-all duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-white/80 text-sm font-medium mb-1">Total de Usuarios</p>
                        <p class="text-3xl font-bold text-white">{{ $stats['total_users'] }}</p>
                    </div>
                    <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center">
                        <i class="fa-solid fa-users text-2xl text-white"></i>
                    </div>
                </div>
            </div>

            <!-- Usuarios Activos -->
            <div class="card-pastel bg-gradient-to-br from-pastel-peach to-pastel-peach/80 hover:shadow-soft-lg transition-all duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-pastel-gray-text/80 text-sm font-medium mb-1">Usuarios Activos</p>
                        <p class="text-3xl font-bold text-pastel-gray-text">{{ $stats['active_users'] }}</p>
                    </div>
                    <div class="w-16 h-16 bg-pastel-gray-text/10 rounded-full flex items-center justify-center">
                        <i class="fa-solid fa-user-check text-2xl text-pastel-gray-text"></i>
                    </div>
                </div>
            </div>

            <!-- Total de Clientes -->
            <div class="card-pastel bg-gradient-to-br from-pastel-yellow to-pastel-yellow/80 hover:shadow-soft-lg transition-all duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-pastel-gray-text/80 text-sm font-medium mb-1">Clientes</p>
                        <p class="text-3xl font-bold text-pastel-gray-text">{{ $stats['total_clients'] }}</p>
                    </div>
                    <div class="w-16 h-16 bg-pastel-gray-text/10 rounded-full flex items-center justify-center">
                        <i class="fa-solid fa-heart text-2xl text-pastel-gray-text"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Accesos rápidos -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Accesos rápidos -->
            <div class="card-pastel">
                <h3 class="text-xl font-bold text-pastel-aqua mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-bolt"></i>
                    Accesos Rápidos
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @if(auth()->user()->hasRole('admin'))
                        <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 p-4 bg-pastel-aqua/10 hover:bg-pastel-aqua/20 rounded-soft transition-all duration-200 group">
                            <div class="w-12 h-12 bg-pastel-aqua rounded-soft flex items-center justify-center group-hover:scale-110 transition-transform">
                                <i class="fa-solid fa-users text-white"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-pastel-gray-text">Usuarios</p>
                                <p class="text-sm text-pastel-gray-text/70">Gestionar usuarios</p>
                            </div>
                        </a>

                        <a href="{{ route('admin.roles.index') }}" class="flex items-center gap-3 p-4 bg-pastel-pink/10 hover:bg-pastel-pink/20 rounded-soft transition-all duration-200 group">
                            <div class="w-12 h-12 bg-pastel-pink rounded-soft flex items-center justify-center group-hover:scale-110 transition-transform">
                                <i class="fa-solid fa-shield-halved text-white"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-pastel-gray-text">Roles</p>
                                <p class="text-sm text-pastel-gray-text/70">Gestionar roles</p>
                            </div>
                        </a>
                    @endif

                    <a href="{{ route('admin.pets.index') }}" class="flex items-center gap-3 p-4 bg-pastel-peach/10 hover:bg-pastel-peach/20 rounded-soft transition-all duration-200 group">
                        <div class="w-12 h-12 bg-pastel-peach rounded-soft flex items-center justify-center group-hover:scale-110 transition-transform">
                            <i class="fa-solid fa-paw text-pastel-gray-text"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-pastel-gray-text">Mascotas</p>
                            <p class="text-sm text-pastel-gray-text/70">Ver todas las mascotas</p>
                        </div>
                    </a>

                    <a href="{{ route('admin.pets.create') }}" class="flex items-center gap-3 p-4 bg-pastel-yellow/10 hover:bg-pastel-yellow/20 rounded-soft transition-all duration-200 group">
                        <div class="w-12 h-12 bg-pastel-yellow rounded-soft flex items-center justify-center group-hover:scale-110 transition-transform">
                            <i class="fa-solid fa-plus text-pastel-gray-text"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-pastel-gray-text">Nueva Mascota</p>
                            <p class="text-sm text-pastel-gray-text/70">Registrar mascota</p>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Mascotas recientes -->
            <div class="card-pastel">
                <h3 class="text-xl font-bold text-pastel-aqua mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-clock"></i>
                    Mascotas Recientes
                </h3>
                @if($stats['recent_pets']->count() > 0)
                    <div class="space-y-3">
                        @foreach($stats['recent_pets'] as $pet)
                            <div class="flex items-center gap-3 p-3 bg-pastel-gray-light rounded-soft hover:bg-pastel-aqua/10 transition-colors">
                                <div class="w-10 h-10 bg-pastel-aqua rounded-full flex items-center justify-center">
                                    <i class="fa-solid fa-paw text-white text-sm"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="font-semibold text-pastel-gray-text">{{ $pet->name }}</p>
                                    <p class="text-sm text-pastel-gray-text/70">{{ $pet->species }} • {{ $pet->owner->name }}</p>
                                </div>
                                <a href="{{ route('admin.pets.show', $pet) }}" class="text-pastel-aqua hover:text-pastel-aqua/80">
                                    <i class="fa-solid fa-arrow-right"></i>
                                </a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fa-solid fa-paw text-4xl text-pastel-gray-text/30 mb-3"></i>
                        <p class="text-pastel-gray-text/70">No hay mascotas registradas aún</p>
                        <a href="{{ route('admin.pets.create') }}" class="inline-block mt-4">
                            <x-wire-button blue>Registrar Primera Mascota</x-wire-button>
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Información adicional -->
        <div class="card-pastel bg-gradient-to-r from-pastel-aqua/5 to-pastel-pink/5">
            <div class="flex flex-col md:flex-row items-center md:items-start gap-4">
                <div class="flex-shrink-0">
                    <div class="w-16 h-16 bg-pastel-aqua rounded-soft flex items-center justify-center">
                        <i class="fa-solid fa-info-circle text-2xl text-white"></i>
                    </div>
                </div>
                <div class="flex-1">
                    <h3 class="text-lg font-bold text-pastel-aqua mb-2">💡 Consejo</h3>
                    <p class="text-pastel-gray-text">
                        Utiliza el menú lateral para navegar rápidamente entre las diferentes secciones del sistema. 
                        Si tienes alguna duda, no dudes en contactar al administrador del sistema.
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
