<x-admin.wrapper>
    <x-slot name="title">
        {{ __('Add Purchase Order') }}
    </x-slot>

    <div>
        <x-admin.breadcrumb href="{{ route('admin.purchase_orders.index') }}" title="{{ __('Purchase Orders') }}">{{ __('<< Back to all Purchase Orders') }}</x-admin.breadcrumb>
        <x-admin.form.errors />
    </div>
    <div class="w-full py-2 overflow-hidden">
        <form method="POST" action="{{ route('admin.purchase_orders.store') }}">
            @csrf

            <div class="py-2">
                <x-admin.form.label for="client_id" class="{{ $errors->has('client_id') ? 'text-red-400' : '' }}">{{ __('Client') }}</x-admin.form.label>
                <select id="client_id" name="client_id" class="input input-bordered w-full {{ $errors->has('client_id') ? 'border-red-400' : '' }}">
                    <option value="">{{ __('Select a client') }}</option>
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}" @if(old('client_id') == $client->id) selected @endif>{{ $client->client_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="py-2">
                <x-admin.form.label for="order_creation_date" class="{{ $errors->has('order_creation_date') ? 'text-red-400' : '' }}">{{ __('Order Creation Date') }}</x-admin.form.label>
                <x-admin.form.input id="order_creation_date" class="{{ $errors->has('order_creation_date') ? 'border-red-400' : '' }}" type="date" name="order_creation_date" value="{{ old('order_creation_date') }}" />
            </div>

            <div class="py-2">
                <x-admin.form.label for="required_delivery_date" class="{{ $errors->has('required_delivery_date') ? 'text-red-400' : '' }}">{{ __('Required Delivery Date') }}</x-admin.form.label>
                <x-admin.form.input id="required_delivery_date" class="{{ $errors->has('required_delivery_date') ? 'border-red-400' : '' }}" type="date" name="required_delivery_date" value="{{ old('required_delivery_date') }}" />
            </div>

            <div class="py-2">
                <x-admin.form.label for="order_consecutive" class="{{ $errors->has('order_consecutive') ? 'text-red-400' : '' }}">{{ __('Order Consecutive') }}</x-admin.form.label>
                <x-admin.form.input id="order_consecutive" class="{{ $errors->has('order_consecutive') ? 'border-red-400' : '' }}" type="text" name="order_consecutive" value="{{ old('order_consecutive') }}" />
            </div>

            <div class="py-2">
                <x-admin.form.label for="delivery_address" class="{{ $errors->has('delivery_address') ? 'text-red-400' : '' }}">{{ __('Delivery Address') }}</x-admin.form.label>
                <x-admin.form.input id="delivery_address" class="{{ $errors->has('delivery_address') ? 'border-red-400' : '' }}" type="text" name="delivery_address" value="{{ old('delivery_address') }}" />
            </div>

            <div class="py-2">
                <x-admin.form.label for="observations" class="{{ $errors->has('observations') ? 'text-red-400' : '' }}">{{ __('Observations') }}</x-admin.form.label>
                <textarea  id="observations" class="{{ $errors->has('observations') ? 'border-red-400' : '' }} input input-bordered w-full " name="observations">{{ old('observations') }}</textarea>
            </div>

            
            <div class="py-4">
                <h3 class="text-lg font-medium">{{ __('Products') }}</h3>
                <div id="products-container" class="border rounded p-4 mt-2">
                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <x-admin.form.label for="products[0][product_id]" class="{{ $errors->has('products.0.product_id') ? 'text-red-400' : '' }}">{{ __('Product') }}</x-admin.form.label>
                            <select id="products[0][product_id]" name="products[0][product_id]" class="input input-bordered w-full {{ $errors->has('products.0.product_id') ? 'border-red-400' : '' }}">
                                <!-- Options will be populated by JavaScript -->
                            </select>
                        </div>
                        <div>
                            <x-admin.form.label for="products[0][price]" class="{{ $errors->has('products.0.price') ? 'text-red-400' : '' }}">{{ __('Price') }}</x-admin.form.label>
                            <x-admin.form.input id="products[0][price]" class="{{ $errors->has('products.0.price') ? 'border-red-400' : '' }} input" type="number" step="0.01" name="products[0][price]" value="{{ old('products.0.price') }}" />
                        </div>
                        <div>
                            <x-admin.form.label for="products[0][quantity]" class="{{ $errors->has('products.0.quantity') ? 'text-red-400' : '' }}">{{ __('Quantity') }}</x-admin.form.label>
                            <x-admin.form.input id="products[0][quantity]" class="{{ $errors->has('products.0.quantity') ? 'border-red-400' : '' }} input" type="number" name="products[0][quantity]" value="{{ old('products.0.quantity') }}" min="1" />
                        </div>
                    </div>
                </div>
                <div class="py-2">
                    <button type="button" id="add-product" class="btn btn-secondary" disabled>{{ __('Add Product') }}</button>
                </div>
            </div>

            <div class="flex justify-end mt-4">
                <x-admin.form.button>{{ __('Add') }}</x-admin.form.button>
            </div>
        </form>
    </div>
</x-admin.wrapper>

<script>
$(document).ready(function() {
    $('#client_id').on('change', function() {
        const clientId = $(this).val();
        const productsContainer = $('#products-container');
        const addProductButton = $('#add-product');

        // Clear the products container
        productsContainer.html(`
            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label for="products[0][product_id]" class="block font-medium text-sm text-gray-700">{{ __('Product') }}</label>
                    <select id="products[0][product_id]" name="products[0][product_id]" class="input input-bordered w-full">
                        <!-- Options will be populated by JavaScript -->
                    </select>
                </div>
                <div>
                    <label for="products[0][price]" class="block font-medium text-sm text-gray-700">{{ __('Price') }}</label>
                    <input id="products[0][price]" name="products[0][price]" type="number" step="0.01" class="input input-bordered w-full" />
                </div>
                <div>
                    <label for="products[0][quantity]" class="block font-medium text-sm text-gray-700">{{ __('Quantity') }}</label>
                    <input id="products[0][quantity]" name="products[0][quantity]" type="number" min="1" class="input input-bordered w-full" />
                </div>
            </div>`);

        // Disable add product button if no client selected
        if (!clientId) {
            addProductButton.prop('disabled', true);
            return;
        }

        // Fetch products and populate the dropdown
        $.getJSON(`/admin/purchase_orders/getClientProducts/${clientId}`, function(data) {
            const productSelect = $('#products-container select[name="products[0][product_id]"]');
            productSelect.html('<option value="">{{ __('Select a product') }}</option>');
            $.each(data, function(index, product) {
                productSelect.append(`<option value="${product.id}">${product.product_name}</option>`);
            });
            addProductButton.prop('disabled', false);
        });
    });

    $('#add-product').on('click', function() {
        const container = $('#products-container');
        const index = container.find('.grid').length;

        const productRowDiv = $(`
            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label for="products[${index}][product_id]" class="block font-medium text-sm text-gray-700">{{ __('Product') }}</label>
                    <select name="products[${index}][product_id]" class="input input-bordered w-full"></select>
                </div>
                <div>
                    <label for="products[${index}][price]" class="block font-medium text-sm text-gray-700">{{ __('Price') }}</label>
                    <input type="number" step="0.01" name="products[${index}][price]" class="input input-bordered w-full" />
                </div>
                <div>
                    <label for="products[${index}][quantity]" class="block font-medium text-sm text-gray-700">{{ __('Quantity') }}</label>
                    <input type="number" min="1" name="products[${index}][quantity]" class="input input-bordered w-full" />
                </div>
            </div>`);

        const existingProducts = $('#products-container select[name="products[0][product_id]"] option');
        existingProducts.each(function() {
            productRowDiv.find('select[name="products[' + index + '][product_id]"]').append(`<option value="${this.value}">${this.text}</option>`);
        });

        container.append(productRowDiv);
    });
});
</script>


