

<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-pet-cream-50 via-pet-orange-50 to-pet-green-50 relative overflow-hidden">
    
    <div class="relative z-10 w-full max-w-6xl px-4 sm:px-6 lg:px-8">
        
        <div class="flex flex-col lg:flex-row items-center justify-center gap-8 lg:gap-12">
            
            <div class="lg:hidden relative z-10">
                
                {{ $logo }}
            </div>

            
            
            @php
                $imagePath = null;
                $imageName = null;
                if (file_exists(public_path('images/perritos.png'))) {
                    $imagePath = asset('images/perritos.png');
                    $imageName = 'perritos.png';
                } elseif (file_exists(public_path('images/perrogato02.png'))) {
                    $imagePath = asset('images/perrogato02.png');
                    $imageName = 'perrogato02.png';
                } elseif (file_exists(public_path('images/perritos.jpg'))) {
                    $imagePath = asset('images/perritos.jpg');
                    $imageName = 'perritos.jpg';
                } elseif (file_exists(public_path('images/perritos.webp'))) {
                    $imagePath = asset('images/perritos.webp');
                    $imageName = 'perritos.webp';
                } elseif (file_exists(public_path('images/dogs.png'))) {
                    $imagePath = asset('images/dogs.png');
                    $imageName = 'dogs.png';
                } elseif (file_exists(public_path('images/dogs.jpg'))) {
                    $imagePath = asset('images/dogs.jpg');
                    $imageName = 'dogs.jpg';
                }
            @endphp
            
            
            @if($imagePath)
            <div class="relative z-10 w-full lg:w-1/2 flex justify-center items-center order-1 lg:order-1 mb-6 lg:mb-0">
                
                
                <img src="{{ $imagePath }}" alt="Perritos" class="w-full max-w-sm sm:max-w-md lg:max-w-lg rounded-3xl shadow-2xl border-4 border-white transform hover:scale-105 transition-transform duration-300">
            </div>
            @endif

            
            
            <div class="relative z-10 w-full {{ $imagePath ? 'lg:w-1/2' : 'sm:max-w-md' }} flex flex-col items-center order-2 lg:order-2">
                
                <div class="hidden lg:block mb-6">
                    {{ $logo }}
                </div>

                
                
                
                <div class="w-full sm:max-w-md px-6 py-6 bg-pet-cream-50/95 backdrop-blur-sm shadow-xl overflow-hidden sm:rounded-2xl border-2 border-pet-orange-200/50">
                    
                    
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
</div>
