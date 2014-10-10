<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>{{{ $title or 'WorldCat Discovery' }}}</title>
    {{ HTML::style('css/blueprint/screen.css', array('media' => 'screen, projection')) }}
    {{ HTML::style('css/discovery.css', array('media' => 'screen, projection')) }}
    {{ HTML::script('http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js') }}
    {{ HTML::script('scripts/dbpediaFetch.js') }}
</head>
<body prefix="schema: http://schema.org/ oclc: http://www.worldcat.org/oclc/ rdf: http://www.w3.org/1999/02/22-rdf-syntax-ns# wcr: https://worldcat.org/wcr/ dc: http://purl.org/dc/terms/ library: http://purl.org/library/">
<div class="container">
    @yield('content')
</div>
</body>
</html>