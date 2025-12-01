<nav class="fixed top-0 z-50 w-full bg-pet-cream-50 border-b border-pet-orange-200/30 shadow-soft">
  <div class="px-3 py-3 lg:px-5 lg:pl-3">
    <div class="flex items-center justify-between">
      <div class="flex items-center justify-start rtl:justify-end">
        <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button" class="inline-flex items-center p-2 text-sm text-pastel-gray-text rounded-soft sm:hidden hover:bg-pastel-aqua/20 focus:outline-none focus:ring-2 focus:ring-pastel-aqua/30 transition-all duration-200">
            <span class="sr-only">Open sidebar</span>
            <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
               <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
            </svg>
         </button>
        <a href="/" class="flex ms-2 md:me-24 items-center">
          <i class="ph ph-paw-print text-3xl text-pet-orange-500 me-3"></i>
          <span class="self-center text-xl font-semibold sm:text-2xl whitespace-nowrap text-pet-orange-500">Mundo Patitas</span>
        </a>
      </div>
      
                <div class="flex items-center gap-3">
                    
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-pet-orange-600 rounded-soft hover:bg-pet-orange-700 focus:outline-none focus:ring-2 focus:ring-pet-orange-500 focus:ring-offset-2 transition-all duration-200">
                            <i class="ph ph-sign-out me-2 text-lg"></i>
                            {{ __('Salir') }}
                        </button>
                    </form>
                    
                    
                    <div class="relative">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                    <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-pet-orange-300 transition">
                                        <img class="size-8 rounded-full object-cover border-2 border-pet-orange-200" 
                                             src="{{ Auth::user()->profile_photo_url }}" 
                                             alt="{{ Auth::user()->name }}"
                                             onerror="this.onerror=null; this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'32\' height=\'32\' viewBox=\'0 0 32 32\'%3E%3Ccircle cx=\'16\' cy=\'16\' r=\'16\' fill=\'%23FF7A2E\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' dominant-baseline=\'central\' text-anchor=\'middle\' font-size=\'16\' fill=\'white\' font-weight=\'bold\'%3E{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}%3C/text%3E%3C/svg%3E';" />
                                    </button>
                                @else
                                    <span class="inline-flex rounded-md">
                                        <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-soft text-pet-orange-700 bg-pet-cream-50 hover:text-pet-orange-500 hover:bg-pet-orange-50 focus:outline-none focus:bg-pet-orange-50 active:bg-pet-orange-100 transition-all ease-in-out duration-200">
                                            {{ Auth::user()->name }}

                                            <svg class="ms-2 -me-0.5 size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                            </svg>
                                        </button>
                                    </span>
                                @endif
                            </x-slot>

                        <x-slot name="content">
                            
                            <div class="block px-4 py-2 text-xs text-pastel-gray-text">
                                {{ __('Manage Account') }}
                            </div>

                            <x-dropdown-link href="{{ route('profile.show') }}">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                <x-dropdown-link href="{{ route('api-tokens.index') }}">
                                    {{ __('API Tokens') }}
                                </x-dropdown-link>
                            @endif

                            <div class="border-t border-pet-orange-200/20"></div>

                            
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf

                                <x-dropdown-link href="{{ route('logout') }}"
                                         @click.prevent="$root.submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>
        </div>
    </div>
  </div>
</nav>
