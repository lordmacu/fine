<x-admin.wrapper>
    <x-slot name="title">
        {{ __('Client Observations') }}
    </x-slot>

    <div class="d-print-none with-border">
        <x-admin.breadcrumb href="{{ route('admin.client.index') }}" title="{{ __('Client Observations') }}">{{ __('<< Back to Clients') }}</x-admin.breadcrumb>
    </div>

    <div class="py-2">
        <div class="min-w-full border-base-200 shadow overflow-x-auto">
            <x-admin.grid.table>
                <x-slot name="head">
                    <tr class="bg-base-200">
                        <x-admin.grid.th>{{ __('Requires Physical Invoice') }}</x-admin.grid.th>
                        <x-admin.grid.th>{{ __('Packaging Unit') }}</x-admin.grid.th>
                        <x-admin.grid.th>{{ __('Requires Appointment') }}</x-admin.grid.th>
                        <x-admin.grid.th>{{ __('Additional Observations') }}</x-admin.grid.th>
                        @canany(['client_observation edit', 'client_observation delete'])
                        <x-admin.grid.th>{{ __('Actions') }}</x-admin.grid.th>
                        @endcanany
                    </tr>
                </x-slot>
                <x-slot name="body">
                    @foreach($observations as $observation)
                        <tr>
                            <td>{{ $observation->requires_physical_invoice ? 'Yes' : 'No' }}</td>
                            <td>{{ $observation->packaging_unit }}</td>
                            <td>{{ $observation->requires_appointment ? 'Yes' : 'No' }}</td>
                            <td>{{ $observation->additional_observations }}</td>
                            @canany(['client_observation edit', 'client_observation delete'])
                            <td>
                                <a href="{{ route('admin.client_observations.edit', [$client->id, $observation->id]) }}" class="btn btn-primary">{{ __('Edit') }}</a>
                                <form action="{{ route('admin.client_observations.destroy', [$client->id, $observation->id]) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">{{ __('Delete') }}</button>
                                </form>
                            </td>
                            @endcanany
                        </tr>
                    @endforeach
                    @empty($observations)
                        <tr>
                            <td colspan="5">
                                <div class="flex flex-col justify-center items-center py-4 text-lg">
                                    {{ __('No Observations Found') }}
                                </div>
                            </td>
                        </tr>
                    @endempty
                </x-slot>
            </x-admin.grid.table>
        </div>
    </div>
</x-admin.wrapper>
