@extends('layouts.master')

@section('content')
<p>Status Code - {{$error->getErrorCode()}}</p>
<p>Error Message - {{$error->getErrorMessage()}}</p>
@stop