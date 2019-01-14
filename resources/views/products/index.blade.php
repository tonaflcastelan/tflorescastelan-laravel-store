@extends('layouts.app')
@section('content')
<?php $products->appends(array('date_start' => $dateStart, 'date_end' => $dateEnd, 'text' => $inputText))->links(); ?>
<div class="container">
	@include('products.partials.search')
	 @if ($message = Session::get('success'))
    <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button> 
        <strong>{{ $message }}</strong>
    </div>
    @endif
    <div id="messages"></div>
    <div class="row">
    	<div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Products List
                    <a href="{{ route('products.create') }}" class="pull-right btn btn-sm btn-success">
                    	<span class="glyphicon glyphicon-plus"></span>
                        Add Product
                    </a>
                    <a href="{{ url('export-products') }}" class="pull-right btn btn-sm btn-warning">
                    	<span class="glyphicon glyphicon-download"></span>
                        Export
                    </a>
                    <a href="#" class="pull-right btn btn-sm btn-danger delete-all">
                    	<span class="glyphicon glyphicon-remove"></span>
                        Delete Selected
                    </a>
                </div>
                <div class="panel-body">
                	<table class="table table-striped table-hover">
						<thead>
							<tr>
								<th><input type="checkbox" id="selectAll" >Select All</th>
								<th>Name</th>
								<th>Description</th>
				                <th>Catego</th>
				                <th>Created</th>
				                <th colspan="3">Actions</th>
				            </tr>
				        </thead>
				        <tbody>
				        	@foreach($products as $product)
				        		<tr>
				        			<td><input type="checkbox" class="product_row" data-id="{{ $product->id }}"></td>
				        			<td>{{ $product->name }}</td>
				        			<td>{{ $product->description }}</td>
				        			<td>{{ $categories[$product->category_id] }}</td>
				        			<td>{{ $product->created }}</td>
				        			<td width="10px">
				        				<a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-info"><span class="glyphicon glyphicon-edit"></span> Edit</a>
				        			</td>
				        			<td width="10px">
				        				<a href="#" class="btn btn-sm btn-danger delete-row" data-id="{{ $product->id }}" data-source="2"><span class="glyphicon glyphicon-remove"></span> Delete</a>
				        			</td>
				        		</tr>
				        	@endforeach
				        </tbody>
					</table>
					{{ $products->render() }}
                </div>
            </div>
        </div>
	</div>
</div>
@endsection