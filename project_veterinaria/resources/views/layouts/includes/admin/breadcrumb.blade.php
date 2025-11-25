{{-- Verifica si hay un elemento en breadcrumb --}}
@if (count($breadcrumbs))
    {{-- Margin bottom --}}
    <nav class="mb-2 bloc">
    {{--Ordered list --}}
    <ol class="flex flex-wrap text-pastel-gray-text text-sm">
         @foreach ($breadcrumbs as $item)
            {{-- List item --}}
            <li class="flex items-center">
                @unless ($loop->first)
                    {{-- El span es un seprador --}}
                    <span class="px-2 text-pastel-aqua/50">/</span>
                @endunless

                {{-- Revisar si existe una llave 'href' --}}
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
    {{-- EL último item aparece como negritas --}}
    @if (count($breadcrumbs) > 1)
    <h6 class="font-bold mt-2 text-pastel-aqua">
        {{ end($breadcrumbs)['name'] }}
    </h6>
    @endif
 </nav>
@endif

