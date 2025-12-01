@php
$links= [
 [
    'name' => 'Dashboard',
    'icon' => 'fa-solid fa-gauge',
    'href' => route('admin.dashboard'),
    'active' => false,
 ],
 [
    'header' => 'Gestión',
 ],
 [
    'name' => 'Mascotas',
    'icon' => 'fa-solid fa-paw',
    'href' => route('admin.pets.index'),
    'active' => request()->routeIs('admin.pets.*'),
    'roles' => ['admin', 'staff'],
 ],
 [
    'name' => 'Roles y Permisos',
    'icon' => 'fa-solid fa-shield-halved',
    'href' => route('admin.roles.index'),
    'active' => request()->routeIs('admin.roles.*'),
    'roles' => ['admin'],
    ],
    [
        'name' => 'Usuarios',
        'icon' => 'fa-solid fa-users',
        'href' => route('admin.users.index'),
        'active' => request()->routeIs('admin.users.*'),
        'roles' => ['admin'],
    ],
];
$userRoles = auth()->user()->roles->pluck('name')->toArray();
$filteredLinks = array_filter($links, function($link) use ($userRoles) {
    if (isset($link['header'])) {
        return true;
    }
    if (!isset($link['roles'])) {
        return true;
    }
    return !empty(array_intersect($link['roles'], $userRoles));
});
@endphp

@endphp
 
<aside id="logo-sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-pet-cream-50 border-r border-pet-orange-200/30 sm:translate-x-0 shadow-soft"
    aria-label="Sidebar">
    <div class="h-full px-3 pb-4 overflow-y-auto bg-pet-cream-50">
        <ul class="space-y-2 font-medium">
            @foreach ($filteredLinks as $link)
                <li>
                    
                    @isset($link['header'])
                        <div class="px-2 py-2 text-xs font-semibold text-pet-orange-700 uppercase">
                            {{ $link['header'] }}
                        </div>
                    
                    @else
                        
                        @isset($link['submenu'])
                            <button type="button" class="flex items-center w-full p-2 text-base text-pastel-gray-text transition-all duration-200 rounded-soft group hover:bg-pastel-aqua/20 hover:text-pastel-aqua" aria-controls="dropdown-example" data-collapse-toggle="dropdown-example">
                                <span class="w-6 h-6 inline-flex justify-center items-center">
                                    <i class="{{ $link['icon'] }}"></i>
                                </span>
                                <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap font-medium">{{$link['name'] }}</span>
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                </svg>
                            </button>
                            <ul id="dropdown-example" class="hidden py-2 space-y-2">
                                @foreach($link['submenu'] as $item)
                                    <li>
                                        <a href="{{$item['href']}}" class="flex items-center w-full p-2 text-pastel-gray-text transition-all duration-200 rounded-soft pl-11 group hover:bg-pastel-aqua/20 hover:text-pastel-aqua">
                                            {{$item['name']}}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <a href="{{ $link['href'] }}"
                                class="flex items-center p-2 text-pastel-gray-text rounded-soft transition-all duration-200 hover:bg-pastel-aqua/20 hover:text-pastel-aqua group {{ $link['active'] ? 'bg-pastel-aqua/30 text-pastel-aqua shadow-soft' : '' }}">
                                <span class="w-6 h-6 inline-flex justify-center items-center">
                                    <i class="{{ $link['icon'] }}"></i>
                                </span>
                                <span class="ms-3 font-medium">{{$link['name'] }}</span>
                            </a>
                        @endisset
                    @endisset
                </li>
            @endforeach
        </ul>
    </div>
</aside>
