<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Checkout form') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="row">
                        <div class="col-md-4 order-md-2 mb-4">
                            <h4 class="d-flex justify-content-between align-items-center mb-3">
                                <span class="text-muted">Tu pedido</span>
                            </h4>

                            <ul class="list-group mb-3">
                                <li class="list-group-item d-flex justify-content-between lh-condensed">
                                    <div>
                                        <h6 class="my-0">{{ $product->name }}</h6>
                                     </div>
                                    <span class="text-muted">$ {{ number_format($product->price, 0, ",", ".") }}</span>
                                </li>

                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Total (COP)</span>
                                    <strong>$ {{ number_format($product->price, 0, ",", ".") }}</strong>
                                </li>
                            </ul>
                        </div>

                        <div class="col-md-8 order-md-1">
                            <h4 class="mb-3">Orden de compra</h4>
                            <form class="needs-validation" novalidate>

                                <div class="mb-3">
                                    <x-label for="name" :value="__('Nombre/Apellido')" />

                                    <x-input id="name" 
                                        class="block mt-1 w-full" 
                                        type="text" name="name"                                          
                                        @auth
                                            :value="old('name', Auth::user()->name)"
                                            disabled
                                        @endauth                                        
                                        required autofocus />
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <x-label for="email" :value="__('Correo electrónico')" />

                                        <x-input id="email" 
                                        class="block mt-1 w-full" 
                                        type="text" name="email" 
                                        @auth
                                            :value="old('email', Auth::user()->email)"
                                            disabled
                                        @endauth   
                                        required autofocus />
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <x-label for="mobile" :value="__('Teléfono')" />

                                        <x-input id="mobile" 
                                        class="block mt-1 w-full" 
                                        type="text" name="mobile" 
                                        @auth
                                            :value="old('mobile', Auth::user()->mobile)"
                                            disabled
                                        @endauth 
                                        required autofocus />
                                    </div>
                                </div>

                                <hr class="mb-4">

                                <h4 class="mb-3">Payment</h4>

                                <hr class="mb-4">

                                <button class="btn btn-lg btn-block btn-success" type="submit">Generar Orden de compra</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
