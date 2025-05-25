@foreach($products as $product)
    <a href="{{ route('products.show', $product) }}" class="block">
        <div class="bg-faceit-light dark:bg-faceit-dark rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 animate-fade-in">
            <!-- Product Image -->
            <div class="h-48 bg-gray-200 overflow-hidden">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center bg-gray-300">
                        <span class="text-gray-500">No image</span>
                    </div>
                @endif
            </div>
            
            <div class="p-4">
                <!-- Product Name -->
                <h3 class="text-lg font-semibold text-faceit-dark dark:text-faceit-light mb-2">{{ $product->name }}</h3>
                
                <!-- Seller Info -->
                <div class="flex items-center mb-3">
                    <div class="w-8 h-8 rounded-full bg-faceit-orange/10 flex items-center justify-center mr-2">
                        <span class="text-sm font-medium text-faceit-orange">
                            {{ strtoupper(substr($product->user->name, 0, 1)) }}
                        </span>
                    </div>
                    <span class="text-sm text-gray-600 dark:text-gray-300">
                        {{ $product->user->name }}
                    </span>
                </div>
                
                <!-- Price -->
                <div class="mt-2">
                    <span class="text-xl font-bold text-faceit-orange">
                        {{ number_format($product->price, 2) }} ₽
                    </span>
                </div>
            </div>
        </div>
    </a>
@endforeach