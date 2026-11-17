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
    } else if (keyword0 == 0 || keyword0 == "") {
        console.log("goodbye");
        
        $('#search_results0').hide();
    } else {
        $('#search_results0').hide();
    }
}


function setTag(tag) {
    var tagID = tag;
    $.ajax({
            url: 'php/ajax_tags_creation.php',
            type: 'POST',
            data: {tag:tagID},
            success:function(data){
                $('#notchWrapper').append(data);
                $('#search_results0').html("");
                $('#search_results0').hide();
                var keyword0 = document.getElementById('tags_id0');
                keyword0.value = '';
            }
        });
}

function removeTag(tagName) {    
    tagName.remove();
}

function createTag() {
    var createTag = document.getElementById('tags_id0').value;

    if (createTag !== "") {
        $.ajax({
            url: 'php/ajax_tags_creation.php',
            type: 'POST',
            data: {tag:createTag},
            success:function(data){
                $('#notchWrapper').append(data);

                $('#search_results0').html("");
                $('#search_results0').hide();
                var keyword0 = document.getElementById('tags_id0');
                keyword0.value = '';
            }
        });
    } else {
        $("#error").text("Cannot add empty tags");
    }
}