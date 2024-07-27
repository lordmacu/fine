<x-admin.wrapper>
    <x-slot name="title">
        {{ __('Clients') }}
    </x-slot>
    
    <div class="d-print-none with-border">
        <x-admin.breadcrumb href="{{ route('admin.client.index') }}" title="{{ __('Clients') }}">{{ __('<< Back to all clients') }}</x-admin.breadcrumb> 
    </div>

    @can('client create')
    <x-admin.add-link href="{{ route('admin.client.create') }}">
        {{ __('Add Client') }}
    </x-admin.add-link>

    <form method="POST" action="{{ route('admin.client.import') }}" enctype="multipart/form-data" class="my-4">
        @csrf
        <div class="flex items-center">
            <input type="file" name="clients_excel" class="form-input" required>
            <x-admin.form.button>{{ __('Upload Excel') }}</x-admin.form.button>
        </div>
    </form>
    @endcan
    
    <div class="py-2">
        <div class="min-w-full border-base-200 shadow overflow-x-auto">
            <x-admin.grid.table>
                <x-slot name="head">
                    <tr class="bg-base-200">
                        <x-admin.grid.th>{{ __('Client Name') }}</x-admin.grid.th>
                        <x-admin.grid.th>{{ __('NIT') }}</x-admin.grid.th>
                        <x-admin.grid.th>{{ __('EMAIL') }}</x-admin.grid.th>
                        <x-admin.grid.th>{{ __('Client Type') }}</x-admin.grid.th>
                        <x-admin.grid.th>{{ __('Payment Type') }}</x-admin.grid.th>
                        @canany(['client edit', 'client delete'])
                        <x-admin.grid.th>{{ __('Actions') }}</x-admin.grid.th>
                        @endcanany
                    </tr>
                </x-slot>
                <x-slot name="body">
                    @foreach($clients as $client)
                        <tr>
                            <td>{{ $client->client_name }}</td>
                            <td>{{ $client->nit }}</td>
                            <td>{{ $client->email }}</td>
<td>{{ $client->payment_type }}</td>
                            @canany(['client edit', 'client delete'])
                            <td>
                                <a href="{{ route('admin.client.edit', $client->id) }}" class="btn btn-primary">{{ __('Edit') }}</a>
                                <form action="{{ route('admin.client.destroy', $client->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">{{ __('Delete') }}</button>
                                </form>
                            </td>
                            @endcanany
                        </tr>
                    @endforeach
                    @empty($clients)
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
