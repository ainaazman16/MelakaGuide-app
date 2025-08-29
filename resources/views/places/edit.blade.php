@extends('adminlte::page')
@section('title', 'Add Place')

@section('content_header')
  <h1>Add Place</h1>
@stop

@section('content')
<form action="{{ route('places.store') }}" method="POST" enctype="multipart/form-data" class="mt-2">
  @csrf
  <x-adminlte-input name="name" label="Name" required/>
  <x-adminlte-input name="category" label="Category" placeholder="Cafe, Library, Park"/>
  <x-adminlte-input name="address" label="Address"/>
  <x-adminlte-textarea name="description" label="Description" rows=4/>
  <x-adminlte-input-file name="cover_image" label="Cover Image"/>
  <button class="btn btn-primary">Save</button>
</form>
@stop
