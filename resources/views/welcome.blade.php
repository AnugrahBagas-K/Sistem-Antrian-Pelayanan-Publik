<!doctype html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @vite('resources/css/app.css')
  </head>
  <body>
    <div class="bg-white">
        <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">
            <h2 class="sr-only">Products</h2>

            <div class="grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8">
            
                @foreach ($instansis as $instansi )

                    <a href="#" class="group"> 
                        <img src="{{ asset('storage/'.$instansi->image) }}" alt="{{ $instansi->nama }}" class="aspect-square w-full rounded-lg bg-gray-200 object-contain group-hover:opacity-75 xl:aspect-7/8" />
                        <p class="text-base font-semibold text-gray-900">{{ $instansi->instansi }}</p>
                    </a>
                    
                @endforeach
            </div>
        </div>
    </div>
  </body>
</html>



