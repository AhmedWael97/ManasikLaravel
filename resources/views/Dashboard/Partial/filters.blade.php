    <div class="row mb-4 mt-4">
        @foreach(array_keys($cols) as $col)
            <div class="col-md-3">
                <label> {{ translate($col) }} </label>
                <input type="text" id="{{ $col }}" class="form-control" />
            </div>
        @endforeach
    </div>
