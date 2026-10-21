function autocomplet0() {
    var min_length = 0; // min characters to display the autocomplete
    var keyword0 = document.getElementById('tags_id0').value;
    
    if (keyword0.length > min_length) {
        $.ajax({
            url: 'php/ajax_tags_processing.php',
            type: 'POST',
            data: {keyword0:keyword0},
            success:function(data){
                $('#search_results0').show();
                $('#search_results0').html(data);
            }
        });
    } else {
        $('#search_results0').hide();
    }
}


function setTag() {
    searchResult = document.getElementById('search_results0').textContent;
    $.ajax({
            url: 'php/ajax_tags_creation.php',
            type: 'POST',
            data: {searchResult:searchResult},
            success:function(data){
                var container = document.getElementById("notchWrapper"); 
                $('#notchWrapper').append(data);

                $('#search_results0').html("");
                $('#search_results0').hide();
                var keyword0 = document.getElementById('tags_id0');
                keyword0.value = '';
            }
        });
}

function removeTag(tagName) {
    var removedTag = tagName;
    removeTag.remove();
}


// function setTag(result) {
//     var searchResult = result;
//     console.log(searchResult);
    
//     //where to put everything
//         var container = document.getElementById("notchWrapper"); 
//     //creates an element
//         var newTag = document.createElement("div"); 
//     //  assigns attributes to the input
//         newTag.setAttribute("class", "notch-arrow");
//         newTag.setAttribute("id", searchResult);
//     // appends the input to the container
//         container.appendChild(newTag);
        


//     $('#search_results0').html("");
//     $('#search_results0').hide();
    
//     searchResult.value = '';
// }

// searchResult = document.getElementById('search_results0').textContent;
//     console.log(searchResult);
    
//     //where to put everything
//         var container = document.getElementById("notchWrapper"); 
//     //creates an element
//         var newTag = document.createElement("div"); 
//     //  assigns attributes to the input
//         newTag.setAttribute("class", "notch-arrow");
//         newTag.setAttribute("id", searchResult);
//     // appends the input to the container
//         container.appendChild(newTag);
        
//         // var tagValue = $('#searchResult');
//         $('#test').innerHTML = "<p class='tag-content' id='tagContent'>searchResult</p>";

//     $('#search_results0').html("");
//     $('#search_results0').hide();
//     var keyword0 = document.getElementById('tags_id0').value;
//     keyword0.value = '';
