<!-- Filter Modal Content -->
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="filterModalLabel">Filter Options</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="{{ route('smoothies.index') }}" method="GET" id="filterForm">
                <!-- Existing Vegan checkbox -->
                <div class="form-group">
                    <label for="filterVegan">Vegan</label>
                    <input type="checkbox" id="filterVegan" class="filter-checkbox" name="filter[]" value="vegan" {{ in_array('vegan', (array)request('filter')) ? 'checked' : '' }}>
                </div>

                <!-- Additional checkboxes for new filters -->
                <div class="form-group">
                    <label for="filterOatmilk">Contains Oatmilk</label>
                    <input type="checkbox" id="filterOatmilk" class="filter-checkbox" name="filter[]" value="oatmilk" {{ in_array('oatmilk', (array)request('filter')) ? 'checked' : '' }}>
                </div>

                <div class="form-group">
                    <label for="filterRegularMilk">Contains Regular Milk</label>
                    <input type="checkbox" id="filterRegularMilk" class="filter-checkbox" name="filter[]" value="regular_milk" {{ in_array('regular_milk', (array)request('filter')) ? 'checked' : '' }}>
                </div>

                <div class="form-group">
                    <label for="filterDetox">Category: Detox</label>
                    <input type="checkbox" id="filterDetox" class="filter-checkbox" name="filter[]" value="detox" {{ in_array('detox', (array)request('filter')) ? 'checked' : '' }}>
                </div>

                <div class="form-group">
                    <label for="filterImmuneSystem">Category: Immune System</label>
                    <input type="checkbox" id="filterImmuneSystem" class="filter-checkbox" name="filter[]" value="immune_system" {{ in_array('immune_system', (array)request('filter')) ? 'checked' : '' }}>
                </div>

                <div class="form-group">
                    <label for="filterEnergyBoost">Category: Energy Boost</label>
                    <input type="checkbox" id="filterEnergyBoost" class="filter-checkbox" name="filter[]" value="energy_boost" {{ in_array('energy_boost', (array)request('filter')) ? 'checked' : '' }}>
                </div>

                <!-- Include the search term in a hidden field -->
                <input type="hidden" name="search" value="{{ $searchTerm ?? '' }}">

                <button type="submit" class="btn btn-primary">Apply Filters</button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        // Update hidden fields based on the state of checkboxes
        document.getElementById('filterForm').addEventListener('submit', function () {
            document.querySelectorAll('.filter-checkbox').forEach(function (checkbox) {
                // Only add hidden fields for checked checkboxes
                if (checkbox.checked) {
                    var hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = checkbox.name;
                    hiddenInput.value = checkbox.value;
                    checkbox.closest('form').appendChild(hiddenInput);
                }
            });
        });
    </script>
@endpush
