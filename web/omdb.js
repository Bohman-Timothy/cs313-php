/*const api = "http://www.omdbapi.com/?apikey=6bb8ca25&"
const output = $("#searchResults")

$("#searchButton").click(function() {
      const target = api + "s=" + $("#searchText").val() //get value from label
      console.log(target)
// Perform an AJAX request using the get() method.
// If the request was successful, append the response.
// If not, append a JSON error object.
$.get(target, function(response) {

  // The most notable difference here is that jQuery attempts to parse JSON
  // responses into a JSON object, whereas vanilla JavaScript returns the
  // result of an AJAX request as a string.
  output.append('<pre>' + JSON.stringify(response, undefined, 2) + '</pre>');
  console.log(JSON.stringify(response));
}).fail(function() {
  output.append('<div>Error</div>');
});
})
*/

/*
const api = "http://www.omdbapi.com/?apikey=6bb8ca25&"
const output = $("#searchResults")

$("#searchButton").click(function() {
      const target = api + "s=" + $("#searchText").val() //get value from label
      console.log(target)

// Perform an AJAX request using the get() method.
// If the request was successful, append the response.
// If not, append a JSON error object.
$.get(target, function(response) {
    console.log(JSON.stringify(response))
    printMovies(response["Search"])
}).fail(function() {
    output.append('<div>Error</div>');
})
})

function printMovies(searchResults) {
    output.empty()
    output.append('<ol>')
    for (var i = 0; i < searchResults.length; ++i) {
        const movieName = searchResults[i]["Title"]
        output.append('<li>' + movieName + '</li>')
    }
    output.append('</ol>')
}
*/

const api = "http://www.omdbapi.com/?apikey=6bb8ca25&"
const output = $("#searchResults")
const outputDetails = $("#detailsArea")


/*$("#searchButton").click(performSearch)
$("#searchButton").keyup(function(event) {
    if (event.keyCode == 13) { //Enter key
        performSearch()
    }
})

function performSearch() {
      const target = api + "s=" + $("#searchText").val() //get value from label
      console.log(target)

// Perform an AJAX request using the get() method.
// If the request was successful, append the response.
// If not, append a JSON error object.
$.get(target, function(response) {
    console.log(JSON.stringify(response))
    printMovies(response["Search"])
}).fail(function() {
    output.append('<div>Error</div>');
})
}*/

/*  //Original -- works without the form wrapped around the search box and button

$("#searchButton").click(function() {
      const target = api + "s=" + $("#searchText").val() //get value from label
      console.log(target)

// Perform an AJAX request using the get() method.
// If the request was successful, append the response.
// If not, append a JSON error object.
$.get(target, function(response) {
    console.log(JSON.stringify(response))
    printMovies(response["Search"])
}).fail(function() {
    output.append('<div>Error</div>');
})
})*/

$("#searchForm").submit(function(e) {
    e.preventDefault()
      const target = api + "s=" + $("#searchText").val() //get value from label
      console.log(target)

// Perform an AJAX request using the get() method.
// If the request was successful, append the response.
// If not, append a JSON error object.
$.get(target, function(response) {
    console.log(JSON.stringify(response))
    printMovies(response["Search"])
}).fail(function() {
    output.append('<div>Error</div>');
})
})

function printMovies(searchResults) {
    output.empty()
    output.append('<ol>')
    for (var i = 0; i < searchResults.length; ++i) {
        const movieName = searchResults[i]["Title"]
        const movieId = searchResults[i]["imdbID"]
        output.append('<li><input type="button" value="Details" onclick="printMovieDetails(\'' + movieId + '\')" id="' + movieId + '"> ' + movieName + '</li>')
/*		output.append(`<li><input type="button" value="Details" onclick="printMovieDetails(\'${movieId}\')" id="button' + i +'">${movieName}</li>`)*/
    }
    output.append('</ol>')
}

/*function printMovieDetails(id) {
    console.log(id)
}*/

function printMovieDetails(id) {
    const target = api + "i=" + id 
    $.get(target, function(response) {

        // The most notable difference here is that jQuery attempts to parse JSON
        // responses into a JSON object, whereas vanilla JavaScript returns the
        // result of an AJAX request as a string.
        console.log(JSON.stringify(response))
        /*output.append('<pre>' + JSON.stringify(response, undefined, 2) + '</pre>');*/
        const jsonResponse = JSON.stringify(response, undefined, 2)
        outputDetails.empty()
		outputDetails.append(`<pre>${JSON.stringify(response, undefined, 2)
}</pre>`);
        outputDetails.append(`<img src=${response["Poster"]}>`)
    }).fail(function() {
        outputDetails.append('<div>Error</div>');

    })

}
