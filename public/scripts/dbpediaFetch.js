/**
 *
 */
$(document).ready(function(){
	// need to get the dbpedia URL from the page somewhere so this isn't static
	var name = $("#more-info h2").attr("id");

	$(function addInfluenced(){
		var url = "http://dbpedia.org/sparql";
		var query = [
		 "SELECT ?givenName, ?surname",
		 "WHERE {",
		    "?s dbpprop:influences <" + name + "> .",
		    "?s foaf:givenName ?givenName .",
		    "?s foaf:surname ?surname .",
		 "}"
		].join(" ");
		
		var queryUrl = url+"?query="+ encodeURIComponent(query) +"&format=json&callback=?";
		
		$.getJSON( queryUrl,
				function (data) {
					if (data.results.bindings.length > 0){
						var influenced = '<h3>Influenced</h3>'; 
						influenced += '<ul id="influenced">';
						$.each(data.results.bindings, function(i,result){
							influenced += '<li>' + result.givenName.value + ' ' + result.surname.value + '</li>';
						});
						influenced += '</ul>';
						$('div#more-info').append(influenced);
					}	
				});
	});
	
	$(function addWorks(){
		var url = "http://dbpedia.org/sparql";
		var query = [
		 "SELECT ?s, ?name",
		 "WHERE {",
		    "?s dbpprop:author <" + name + "> .",
		    "?s dbpprop:name ?name .",
		 "}"
		].join(" ");
		
		var queryUrl = url+"?query="+ encodeURIComponent(query) +"&format=json&callback=?";
		
		$.getJSON( queryUrl,
				function (data) {
					if (data.results.bindings.length > 0){
						var works = '<h3>Works</h3>'; 
						works += '<ul id="works">';
						$.each(data.results.bindings, function(i,result){
							works += '<li><a href="' + result.s.value + '">' + result.name.value + '</a></li>';
						});
						works += '</ul>';
						$('div#more-info').append(works);
					}	
				});
	});
	
	$(function addAppearances(){
		var url = "http://dbpedia.org/sparql";
		var query = [
		 "SELECT ?s, ?name",
		 "WHERE {",
		    "?s dbpprop:starring <" + name + "> .",
		    "?s dbpprop:name ?name .",
		 "}"
		].join(" ");
		
		var queryUrl = url+"?query="+ encodeURIComponent(query) +"&format=json&callback=?";
		
		$.getJSON( queryUrl,
				function (data) {
					if (data.results.bindings.length > 0){
						var appearedIn = '<h3>Appeared In</h3>'; 
						appearedIn += '<ul id="appearedIn">';
						$.each(data.results.bindings, function(i,result){
							appearedIn += '<li><a href="' + result.s.value + '">' + result.name.value + '</a></li>';
						});
						appearedIn += '</ul>';
						$('div#more-info').append(appearedIn);
					}
				});
	});
		
});	