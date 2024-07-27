<x-admin.wrapper>
    <x-slot name="title">
        {{ __('Purchase Orders') }}
    </x-slot>

    <div class="d-print-none with-border">
        <x-admin.breadcrumb href="{{ route('admin.purchase_orders.index') }}" title="{{ __('Purchase Orders') }}">
            {{ __('<< Back to all Purchase Orders') }}
        </x-admin.breadcrumb>
    </div>

    @can('purchase_order create')
    <x-admin.add-link href="{{ route('admin.purchase_orders.create') }}">
        {{ __('Add Purchase Order') }}
    </x-admin.add-link>
    @endcan

    <div class="py-2">
        <div class="min-w-full border-base-200 shadow overflow-x-auto">
            <x-admin.grid.table>
                <x-slot name="head">
                    <tr class="bg-base-200">
                        <x-admin.grid.th>{{ __('Order Consecutive') }}</x-admin.grid.th>
                        <x-admin.grid.th>{{ __('Client') }}</x-admin.grid.th>
                        <x-admin.grid.th>{{ __('Order Creation Date') }}</x-admin.grid.th>
                        <x-admin.grid.th>{{ __('Required Delivery Date') }}</x-admin.grid.th>
                        <x-admin.grid.th>{{ __('Delivery Address') }}</x-admin.grid.th>
                        <x-admin.grid.th>{{ __('Actions') }}</x-admin.grid.th>
                    </tr>
                </x-slot>
                <x-slot name="body">
                    @foreach($purchaseOrders as $purchaseOrder)
                        <tr>
                            <td>{{ $purchaseOrder->order_consecutive }}</td>
                            <td>{{ $purchaseOrder->client->client_name }}</td>
                            <td>{{ $purchaseOrder->order_creation_date }}</td>
                            <td>{{ $purchaseOrder->required_delivery_date }}</td>
                            <td>{{ $purchaseOrder->delivery_address }}</td>
                            <td>
                                <a href="{{ route('admin.purchase_orders.show', $purchaseOrder->id) }}" class="btn btn-primary">{{ __('View') }}</a>
                                <a href="{{ route('admin.purchase_orders.edit', $purchaseOrder->id) }}" class="btn btn-secondary">{{ __('Edit') }}</a>
                                <form action="{{ route('admin.purchase_orders.destroy', $purchaseOrder->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">{{ __('Delete') }}</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    @empty($purchaseOrders)
                        <tr>
                            <td colspan="6">
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
