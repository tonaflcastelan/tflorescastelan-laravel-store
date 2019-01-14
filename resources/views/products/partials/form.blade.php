<div class="form-group">
	{{ Form::label('name', 'Name') }}
	{{ Form::text('name', null, ['class' => 'form-control', 'id' => 'name']) }}
</div>
<div class="form-group">
	{{ Form::label('price', 'Price') }}
	{{ Form::text('price', null, ['class' => 'form-control', 'id' => 'price']) }}
</div>
<div class="form-group">
	{{ Form::label('description', 'Description') }}
	{{ Form::text('description', null, ['class' => 'form-control', 'id' => 'description']) }}
</div>
<div class="form-group">
	{{ Form::label('category_id', 'Category') }}
	{{ Form::select('category_id', $categories, null, ['class' => 'form-control']) }}
</div>
<div class="form-group">
  	{{ Form::submit('Save', ['class' => 'btn btn-sm btn-primary']) }}
</div>