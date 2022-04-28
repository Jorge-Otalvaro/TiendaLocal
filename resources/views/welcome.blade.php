<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <!-- Bootstrap core CSS -->
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="{{ asset('css/pricing.css') }}" rel="stylesheet">

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation-guest')

            <div class="font-sans text-gray-900 antialiased">
                <div class="py-12">                  
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">                        
                        <div class="card-deck mb-3 text-center">
                            @foreach($products as $product)
                                <div class="card mb-4 box-shadow">
                                    <div class="card-header">
                                        <h4 class="my-0 font-weight-normal">{{ Str::limit($product->name, 30) }}</h4>
                                    </div>

                                    <div class="card-body">
                                        <h1 class="card-title pricing-card-title">
                                            {{ $product->total_format }}
                                        </h1>
                                        <a class="btn btn-lg btn-block btn-outline-primary" href="{{ route('checkout', $product->id) }}">Comprar</a>
                                    </div>
                                </div>   
                            @endforeach                                   
                        </div>   

                        {!! $products->links() !!} 

                        @if(count($products) <= 0)
                            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                <div class="p-6 bg-white border-b border-gray-200">
                                    No tenemos productos registrados.
                                    <a class="btn btn-lg btn-block btn-success" href="{{ route('new-products') }}">
                                        Cargar nuevos registros
                                    </a>
                                </div>
                            </div>  
                        @endif
                    </div>
                </div>                
            </div>  
        </div>      

        @include('sweetalert::alert')
    </body>
</html>
