<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('‎Payment Methods') }}
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
                                        <h6 class="my-0">{{ $order->product->name }}</h6>
                                     </div>
                                    <span class="text-muted">{{ $order->product->total_format }}</span>
                                </li>

                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Total (COP)</span>
                                    <strong>{{ $order->product->total_format }}</strong>
                                </li>
                            </ul>
                        </div>

                        <div class="col-md-8 order-md-1">
                            <h4 class="mb-3">
                                Resumen de la orden {{ $order->id }} - 
                                @if($order->status == "CREATED")
                                    <span class="badge badge-pill badge-warning">
                                        Pendiente de pago
                                    </span>
                                @elseIf($order->status == "PAYED")
                                    <span class="badge badge-pill badge-success">
                                        Pagada
                                    </span>
                                @else 
                                    <span class="badge badge-pill badge-danger">
                                        {{ $order->status }}
                                    </span>
                                @endif  
                            </h4>
                            <form class="needs-validation" novalidate>

                                <hr class="mb-4">

                                @if($order->status == "CREATED" && "REJECTED")

                                    <h4 class="mb-3">Método de pago</h4>

                                    <div class="d-block my-3">
                                        <div class="custom-control custom-radio">

                                            <input id="credit" name="paymentMethod" type="radio" class="custom-control-input" checked required>

                                            <label class="custom-control-label" for="credit">
                                                Usar pasarela de pago PlacetoPay
                                            </label>
                                        </div>              
                                    </div>

                                    <hr class="mb-4">  

                                    <a href="{{ route('orders.payment', ["order" => $order->id]) }}" class="btn btn-lg btn-block btn-success" >
                                        Pagar orden de compra
                                    </a>
                                @endif                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
