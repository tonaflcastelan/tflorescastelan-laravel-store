@extends('layouts.app')

@section('content')

<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				@if(!$errors->isEmpty())
					<div class="alert alert-danger">
						 @foreach ($errors->all() as $error)
						    <p>{{ $error }}</p>
						@endforeach
					</div>
				@endif
				<div class="panel-heading">
					Edit Product {{ $product->name}}
					<a href="{{ url()->previous() }}" class="pull-right btn btn-sm btn-primary">
                        Back
                    </a>
				</div>
				<div id="messages"></div>
				<div class="panel-body">
					{!! Form::model($product, ['route' => ['products.update', $product->id], 'method' => 'PUT']) !!}
                        @include('products.partials.form')
                    {!! Form::close() !!}
				</div>
				<div id="messages"></div>
				<div id="map_canvas" style="width:100%;height:400px;"></div>
			</div>
		</div>
	</div>
</div>
@endsection