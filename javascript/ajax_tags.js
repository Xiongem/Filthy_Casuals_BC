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
    $('#search_results0').html("");
    $('#search_results0').hide();
    var keyword0 = document.getElementById('tags_id0');
    keyword0.value = '';

    // var container = document.getElementById("tagContainer");

    // while (container.hasChildNodes()) {
    //     container.removeChild(container.lastChild);
    // }
    // for (let i = 0; i < tag_number.value; i++) {
    //     container.appendChild(document.createTextNode(keyword0));
    //     var player = document.createElement("input");
    //     player.setAttribute("type", "text");
    //     player.setAttribute("class", "tag");
    //     player.setAttribute("name", "tag" + (i));
    //     player.setAttribute("id", keyword0);
    //     document.getElementById("showPlayers").appendChild(player);
    // }
}

// function displayPlayers(){
//             let players = document.getElementById("playerNumber");
//             var container = document.getElementById("showPlayers");
//             while (container.hasChildNodes()) {
//                 container.removeChild(container.lastChild);
//             }
//             for (let i = 0; i < players.value; i++) {
//                 container.appendChild(document.createTextNode("Player " + (i+1)));
//                 var player = document.createElement("input");
//                 player.setAttribute("type", "text");
//                 player.setAttribute("class", "playerInput");
//                 player.setAttribute("name", "gameplayer" + (i+1));
//                 player.setAttribute("id", (i+1));
//                 document.getElementById("showPlayers").appendChild(player);
//             }
//         }