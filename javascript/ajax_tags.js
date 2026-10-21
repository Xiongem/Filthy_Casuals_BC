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

// function set_item(item) {
//     $('#search_id0').val(item);
//     $('#search_results0').hide();
// }

function setTag() {
    //where to put everything
        var container = document.getElementById("notchWrapper"); 
    //creates an element
        var tag = document.createElement("div"); 
    //  assigns attributes to the input
        tag.setAttribute("class", "notch-arrow");
        tag.setAttribute("id", keyword0);
    // appends the input to the container
        container.appendChild(tag);
        $('#keyword0').html(keyword0);


    $('#search_results0').html("");
    $('#search_results0').hide();
    var keyword0 = document.getElementById('tags_id0');
    keyword0.value = '';
}

// function displayPlayers(){
//             let players = document.getElementById("playerNumber");x
//             var container = document.getElementById("showPlayers"); //where to put everything
//             while (container.hasChildNodes()) {
//                 container.removeChild(container.lastChild);
//             }
//             for (let i = 0; i < players.value; i++) {
                    //assigns a label
//                 container.appendChild(document.createTextNode("Player " + (i+1))); 
                    //creates an element
//                 var player = document.createElement("input"); 
                    //assigns attributes to the input
//                 player.setAttribute("type", "text");
//                 player.setAttribute("class", "playerInput");
//                 player.setAttribute("name", "gameplayer" + (i+1));
//                 player.setAttribute("id", (i+1));
                    //appends the input to the container
//                 document.getElementById("showPlayers").appendChild(player);
//             }
//         }'<p class="tag-content" id="tagContent">keyword0</p>'