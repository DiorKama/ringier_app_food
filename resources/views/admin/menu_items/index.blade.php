<x-master-layout>
    <div class="container mt-5 p-4">
        <h4>Menu du jour</h4>
        <div class="row">
            <div class="col-12 text-right">
                <a href="{{ route('admin.menu_items.create') }}" class="btn btn-primary">+ Ajouter un plat au menu</a>
            </div>
            <div class="row mt-3">
                @foreach($menuItems as $menuItem)
                    <div class="col-md-3 col-sm-6 mb-4">
                        <div class="card h-100 shadow-sm">
                            @php
                                $imagePath = $menuItem->items->item_thumb ? asset($menuItem->items->item_thumb) : asset('default.png');
                            @endphp
                            <a href="{{ route('admin.menu_items.edit', $menuItem->id) }}">
                                <img class="card-img-top" src="{{ $imagePath }}" alt="{{ $menuItem->items->title }}" style="aspect-ratio: 16 / 9; object-fit: scale-down;">
                            </a>
                            <div class="card-body text-center">
                                <h5 class="card-title font-weight-bold float-none">{{ $menuItem->items->title }}</h5>
                                <p class="card-text ">{{ $menuItem->items->restaurants->title }}</p>
                                <p class="card-text font-weight-bold">{{ number_format($menuItem->price, 0, ',', ' ') }} F CFA</p>
                                <form action="{{ route('admin.menu_items.destroy', $menuItem->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-block btn-primary"><i class="fas fa-trash"></i>Retirer</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-master-layout>




