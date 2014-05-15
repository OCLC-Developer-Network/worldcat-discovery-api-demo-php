@extends('layouts.master')

@section('content')
<p>Status Code - {{$error->getCode()}}</p>
<p>Error Message - {{$$error->getMessage()}}</p>
<h4>Request</h4>
<pre>
{{$error->getRequest()}}

</pre>
@stop