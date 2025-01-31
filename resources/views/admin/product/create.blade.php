<x-admin.wrapper>
    <x-slot name="title">
        {{ __('Products') }}
    </x-slot>

    <div>
        <x-admin.breadcrumb href="{{ route('admin.product.index') }}" title="{{ __('Add Product') }}">{{ __('<< Back to Products') }}</x-admin.breadcrumb>
        <x-admin.form.errors />
    </div>
    <div class="w-full py-2 overflow-hidden">
        <form method="POST" action="{{ route('admin.product.store') }}">
            @csrf

            <div class="py-2">
                <x-admin.form.label for="code" class="{{ $errors->has('code') ? 'text-red-400' : '' }}">{{ __('Code') }}</x-admin.form.label>
                <x-admin.form.input id="code" class="{{ $errors->has('code') ? 'border-red-400' : '' }}" type="text" name="code" value="{{ old('code') }}" />
            </div>

            <div class="py-2">
                <x-admin.form.label for="product_name" class="{{ $errors->has('product_name') ? 'text-red-400' : '' }}">{{ __('Product Name') }}</x-admin.form.label>
                <x-admin.form.input id="product_name" class="{{ $errors->has('product_name') ? 'border-red-400' : '' }}" type="text" name="product_name" value="{{ old('product_name') }}" />
            </div>

            <div class="py-2">
                <x-admin.form.label for="price" class="{{ $errors->has('price') ? 'text-red-400' : '' }}">{{ __('Price') }}</x-admin.form.label>
                <x-admin.form.input id="price" class="{{ $errors->has('price') ? 'border-red-400' : '' }}" type="number" step="0.01" name="price" value="{{ old('price') }}" />
            </div>

            <div class="py-2">
                <x-admin.form.label for="client_id" class="{{ $errors->has('client_id') ? 'text-red-400' : '' }}">{{ __('Client') }}</x-admin.form.label>
                <select id="client_id" name="client_id" class="input input-bordered w-full {{ $errors->has('client_id') ? 'border-red-400' : '' }}">
                    <option value="">{{ __('Select a client') }}</option>
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}" @if(old('client_id') == $client->id) selected @endif>{{ $client->client_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex justify-end mt-4">
                <x-admin.form.button>{{ __('Create') }}</x-admin.form.button>
            </div>
        </form>
    </div>
</x-admin.wrapper>
