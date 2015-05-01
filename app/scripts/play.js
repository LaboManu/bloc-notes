          // Search for a specified string.
            function playsong(searchStr) {
                $("#search-container").html("" + 
                "<a href='https://www.youtube.com/results?search_query=" +
                    searchStr+"' target='new'>link</a>" +
                    "<a id='query' onclick='search()'></a>"+
                    ""
                    );
                /*$("#media").attr('src', "https://www.youtube.com/results?search_query=" +
                    searchStr);*/
                $("#query").html(rawurlencode(searchStr));
            }
            
                $( "a" ).click(function( event ) {
                event.preventDefault();
                playsong($( this ).attr("value"));
                
                
            });
            

// Search for a specified string.
function search() {
  var q = $('#query').html();
  var request = gapi.client.youtube.search.list({
    q: q,
    part: 'snippet'
  });

  request.execute(function(response) {
    var str = JSON.stringify(response.result);
    $('#search-container').html('<pre>' + str + '</pre>');
  });
}