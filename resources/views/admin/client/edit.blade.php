<x-admin.wrapper>
    <x-slot name="title">
        {{ __('Clients') }}
    </x-slot>

    <div>
        <x-admin.breadcrumb href="{{ route('admin.client.index') }}" title="{{ __('Update Client') }}">{{ __('<< Back to Clients') }}</x-admin.breadcrumb>
        <x-admin.form.errors />
    </div>
    <div class="w-full py-2 overflow-hidden">
        <form method="POST" action="{{ route('admin.client.update', $client->id) }}">
            @csrf
            @method('PUT')

            <div class="py-2">
                <x-admin.form.label for="client_name" class="{{ $errors->has('client_name') ? 'text-red-400' : '' }}">{{ __('Client Name') }}</x-admin.form.label>
                <x-admin.form.input id="client_name" class="{{ $errors->has('client_name') ? 'border-red-400' : '' }}" type="text" name="client_name" value="{{ old('client_name', $client->client_name) }}" />
            </div>

            <div class="py-2">
                <x-admin.form.label for="nit" class="{{ $errors->has('nit') ? 'text-red-400' : '' }}">{{ __('NIT') }}</x-admin.form.label>
                <x-admin.form.input id="nit" class="{{ $errors->has('nit') ? 'border-red-400' : '' }}" type="text" name="nit" value="{{ old('nit', $client->nit) }}" />
            </div>

            <div class="py-2">
                <x-admin.form.label for="client_type" class="{{ $errors->has('client_type') ? 'text-red-400' : '' }}">{{ __('Client Type') }}</x-admin.form.label>
                <select id="client_type" name="client_type" class="input input-bordered w-full {{ $errors->has('client_type') ? 'border-red-400' : '' }}">
                    <option value="pareto" {{ old('client_type', $client->client_type) == 'pareto' ? 'selected' : '' }}>Pareto</option>
                    <option value="balance" {{ old('client_type', $client->client_type) == 'balance' ? 'selected' : '' }}>Balance</option>
                </select>
            </div>

            <div class="py-2">
                <x-admin.form.label for="payment_type" class="{{ $errors->has('payment_type') ? 'text-red-400' : '' }}">{{ __('Payment Type') }}</x-admin.form.label>
                <select id="payment_type" name="payment_type" class="input input-bordered w-full {{ $errors->has('payment_type') ? 'border-red-400' : '' }}">
                    <option value="cash" {{ old('payment_type', $client->payment_type) == 'cash' ? 'selected' : '' }}>Cash</option>
                    <option value="credit" {{ old('payment_type', $client->payment_type) == 'credit' ? 'selected' : '' }}>Credit</option>
                </select>
            </div>


            <div class="py-2">
                <x-admin.form.label for="email" class="{{ $errors->has('email') ? 'text-red-400' : '' }}">{{ __('Email') }}</x-admin.form.label>
                <x-admin.form.input id="email" class="{{ $errors->has('email') ? 'border-red-400' : '' }}" type="email" name="email" value="{{ old('email', $client->email) }}" />
            </div>

            <div class="flex justify-end mt-4">
                <x-admin.form.button>{{ __('Update') }}</x-admin.form.button>
            </div>
        </form>
    </div>
</x-admin.wrapper>
