<div class="row">
<x-adminlte-input
    type="text"
    name="name"
    label="Product name:*"
    placeholder="Product name"
    fgroup-class="col-md-4"
    class="{{ $errors->has('name') ? 'is-invalid' : '' }}"
    id="name"
    value="{{ old('name', isset($product) ? $product->name : '') }}"
    autocomplete="off" required/>

<x-adminlte-input
    type="text"
    name="unit_price"
    label="Product price:*"
    placeholder="Product price"
    fgroup-class="col-md-3"
    class="{{ $errors->has('unit_price') ? 'is-invalid' : '' }}"
    id="unit_price"
    value="{{ old('unit_price', isset($product) ? $product->price : '') }}"
    autocomplete="off"
    required />

    <x-adminlte-select2
    name="category"
    label="Category:*"
    data-placeholder="Select an option..."
    fgroup-class="col-md-2"
    class="{{ $errors->has('category') ? 'is-invalid' : '' }}"
    id="category"
    autocomplete="off"
    required
>
    <option value="" disabled>Please select an option...</option>
    <option value="Recruitment" {{ old('category', isset($product) ? $product->category : '') == 'Pending' ? 'selected' : '' }}>Recruitment</option>
</x-adminlte-select2>

<x-adminlte-textarea
    type="text"
    name="description"
    label="Description:*"
    placeholder="Description"
    fgroup-class="col-md-12"
    class="{{ $errors->has('description') ? 'is-invalid' : '' }}"
    id="description"
    autocomplete="off"
    style="height: 200px;"
    required>
    {{ old('description', isset($product) ? $product->description : '') }}
</x-adminlte-textarea>
</div>

