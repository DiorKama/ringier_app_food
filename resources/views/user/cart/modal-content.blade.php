<x-monheader>
</x-monheader>
<!-- Modal structure -->
<div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cartModalLabel">Votre Panier</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
            @if(isset($cart) && $cart->isNotEmpty())
                <ul class="list-group">
                    @foreach($cart as $item)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $item->menuItems->items->restaurants->title }} - {{ $item->menuItems->items->title }} - {{ $item->quantity }} x {{ $item->unit_price }} CFA
                            <form action="{{ route('user.order.removeItem', $item->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </li>
                    @endforeach
               </ul>
            @else
                <p>Votre panier est vide.</p>
            @endif

            <div class="modal-footer">
                <a href="{{ route('user.order.checkout') }}" class="btn btn-primary">Finaliser la commande</a>
            </div>
            
        </div>
    </div>
</div>

<x-monbody>
</x-monbody>