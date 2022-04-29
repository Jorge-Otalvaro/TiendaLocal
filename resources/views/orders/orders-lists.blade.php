<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Orders Lists') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col"># Pedido</th>
                                <th scope="col">Producto</th>
                                <th scope="col">Valor</th>
                                <th scope="col">Estado</th>
                                <th scope="col">Fecha</th>
                                <th scope="col">Acción</th>                                
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <th scope="row">{{ $order->id }}</th>
                                    <td>{{ $order->product->name }}</td>
                                    <td>{{ $order->product->total_format }}</td>
                                    <td>     
                                        @if($order->status == "CREATED")
                                            <span class="badge badge-pill badge-warning">
                                                {{ $order->status }}
                                            </span>
                                        @elseIf($order->status == "PAYED")
                                            <span class="badge badge-pill badge-success">
                                                {{ $order->status }}
                                            </span>
                                        @else 
                                            <span class="badge badge-pill badge-danger">
                                                {{ $order->status }}
                                            </span>
                                        @endif                                        
                                    </td>
                                    <td>{{ $order->created_at }}</td>
                                    <td>
                                        @if($order->status == "CREATED")
                                            <a target="_blank" href="{{ route('orders.show', ["order" => $order->id]) }}" class="badge badge-pill badge-success">
                                                Pendiente de pago
                                            </a>
                                        @else    
                                            <a href="{{ route('orders.show', ["order" => $order->id]) }}" class="badge badge-pill badge-warning">
                                                Ver detalle de la orden
                                            </a>                                         
                                        @endif  
                                    </td>                                    
                                </tr>
                            @endforeach()
                        </tbody>
                    </table>

                    {!! $orders->links() !!} 
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
