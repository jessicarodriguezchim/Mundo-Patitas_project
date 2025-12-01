
@if (count($breadcrumbs))
    
    <nav class="mb-2 bloc">
    
    <ol class="flex flex-wrap text-pastel-gray-text text-sm">
         @foreach ($breadcrumbs as $item)
            
            <li class="flex items-center">
                @unless ($loop->first)
                    
                    <span class="px-2 text-pastel-aqua/50">/</span>
                @endunless

                
                @isset($item['href'])
                    <a href="{{ $item['href'] }}" class="opacity-60 hover:opacity-100 hover:text-pastel-aqua transition-colors duration-200">
                        {{ $item['name'] }}
                    </a>
                @else
                  <span class="text-pastel-aqua font-medium">{{ $item['name'] }}</span>
                @endisset

            </li>
         @endforeach
    </ol>
    
    @if (count($breadcrumbs) > 1)
    <h6 class="font-bold mt-2 text-pastel-aqua">
        {{ end($breadcrumbs)['name'] }}
    </h6>
    @endif
 </nav>
@endif

