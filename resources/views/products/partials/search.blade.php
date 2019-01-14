<fieldset>
    <legend>Form Search</legend>
    <form>
        <div class="col-md-12">
            <div class="form-group col-md-4">
                <label for="station_name">Product Name / Description</label>
                {{ Form::text('text', null, ['class' => 'form-control', 'id' => 'text', 'placeholder' => 'Name / Description', 'autocomplete' => 'off']) }}
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group col-md-6">
                <label for="date_start">Date Start</label>
                {{ Form::text('date_start', $dateStart, ['class' => 'form-control', 'id' => 'date_start', 'placeholder' => 'Date Start', 'autocomplete' => 'off']) }}
            </div>
            <div class="form-group col-md-6">
                <label for="date_end">Date End</label>
                {{ Form::text('date_end', $dateEnd, ['class' => 'form-control', 'id' => 'date_end', 'placeholder' => 'Date End', 'autocomplete' => 'off']) }}
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Search</button>
        <a class="btn pull-right" href="{{ url('products') }}">Clean Form</a>
    </form>
</fieldset>