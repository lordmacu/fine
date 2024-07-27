<x-admin.wrapper>
    <x-slot name="title">
        {{ __('Products') }}
    </x-slot>
    
    <div class="d-print-none with-border">
        <x-admin.breadcrumb href="{{route('admin.product.index')}}" title="{{ __('Products') }}">{{ __('<< Back to all products') }}</x-admin.breadcrumb> 
    </div>

    @can('product create')
    <x-admin.add-link href="{{ route('admin.product.create') }}">
        {{ __('Add Product') }}
    </x-admin.add-link>
    @endcan
    
    <div class="py-2">
        <div class="min-w-full border-base-200 shadow overflow-x-auto">
            <x-admin.grid.table>
                <x-slot name="head">
                    <tr class="bg-base-200">
                        <x-admin.grid.th>{{ __('Code') }}</x-admin.grid.th>
                        <x-admin.grid.th>{{ __('Product Name') }}</x-admin.grid.th>
                        <x-admin.grid.th>{{ __('Price') }}</x-admin.grid.th>
                        <x-admin.grid.th>{{ __('Client') }}</x-admin.grid.th>
                        @canany(['product edit', 'product delete'])
                        <x-admin.grid.th>{{ __('Actions') }}</x-admin.grid.th>
                        @endcanany
                    </tr>
                </x-slot>
                <x-slot name="body">
                    @foreach($products as $product)
                        <tr>
                            <td>{{ $product->code }}</td>
                            <td>{{ $product->product_name }}</td>
                            <td>{{ $product->price }}</td>
                            <td>{{ $product->client->client_name }}</td>
                            @canany(['product edit', 'product delete'])
                            <td>
                                <a href="{{ route('admin.product.edit', $product->id) }}" class="btn btn-primary">{{ __('Edit') }}</a>
                                <form action="{{ route('admin.product.destroy', $product->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">{{ __('Delete') }}</button>
                                </form>
                            </td>
                            @endcanany
                        </tr>
                    @endforeach
                    @empty($products)
                        <tr>
                            <td colspan="5">
                                <div class="flex flex-col justify-center items-center py-4 text-lg">
                                    {{ __('No Result Found') }}
                                </div>
                            </td>
                        </tr>
                    @endempty
                </x-slot>
            </x-admin.grid.table>
        </div>
    </div>
</x-admin.wrapper>
