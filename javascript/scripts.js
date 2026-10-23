//adds a show password option
function showPassword() {
  var showPass = document.getElementById("password");
  var confirmPass = document.getElementById("retypePassword");
  if (showPass.type === "password") {
    showPass.type = "text";
    confirmPass.type = "text";
  } else {
    showPass.type = "password";
    confirmPass.type = "password";
  }
} 

function upload() {

  const fileUploadInput = document.querySelector('.file-uploader');

  // using index [0] to take the first file from the array
  const image = fileUploadInput.files[0];

  // check if the file selected is not an image file
  if (!image.type.includes('image')) {
    return alert('Only images are allowed!');
  }

  // check if size (in bytes) exceeds 10 MB
  if (image.size > 10_000_000) {
    return alert('Maximum upload size is 10MB!');
  }
    const fileReader = new FileReader();
  fileReader.readAsDataURL(image);

  fileReader.onload = (fileReaderEvent) => {
    const profilePicture = document.querySelector('.profile-picture');
    profilePicture.style.backgroundImage = `url(${fileReaderEvent.target.result})`;
  }
}

function hideBackground() {
  $("#body").css({"height": "100%", "overflow": "hidden"});
  // var body = document.getElementById("body");
  // body.style.height = "100%";
  // body.style.overflow = "hidden";
}
function showBackground() {
  $("#body").css({"height": "unset", "overflow": "unset"});
  // var body = document.getElementById("body");
  // body.style.height = "unset";
  // body.style.overflow = "unset";
}

function editRead(readID) {
  $("#editPopup").css({"display": "flex"});
  var editPopup = document.getElementById("editPopup");
  editPopup.scrollIntoView();
  setTimeout(hideBackground, 500);

  var read_ID = readID;
  $.ajax({
      url: 'php/ajax_history_edit.php',
      method: 'post',
      data: {read_ID:read_ID,
            userID:userID},
      success: function(result) {
          $("#editResults").html(result);
      }
  });
}
function closeEditRead() {
  $("#editPopup").hide();
  $("#body").css({"height": "unset", "overflow": "unset"});
  // var body = document.getElementById("body");
  // document.getElementById("project-popup").style.display = "none";
  // body.style.height = "unset";
  // body.style.overflow = "unset";
}