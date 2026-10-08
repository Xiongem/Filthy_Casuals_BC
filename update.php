<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta property="og:title" content="Filthy Casual Book Challenge"> 
    <meta property="og:description" content="A competition for filthy casuals."> 
    <meta property="og:image" content=""> 
    <meta property="og:url" content="">
    <title>Update</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/home.css">
    <link rel="website icon" type="svg" href="images/FCBClogo.svg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/ea9288eda1.js" crossorigin="anonymous"></script>
    <script src="javascript/scripts.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
    <header>
        <?= makeNav() ?>
    </header>
    <div class="update-wrapper">
        <div class="update-content">
            <h1>Update Your Reading History</h1>
            <form action="process-update.php" method="post">
                <label for="title" class="labels">Book Title:</label>
                <input type="text"
                    name="title"
                    id="title"
                    class="inputs"
                    required>

                <label for="author" class="labels">Author:</label>
                <input type="text"
                    name="author"
                    id="author"
                    class="inputs"
                    required>

                <label for="diffDate" class="labels">Click if your finish date is not today:</label>
                <input type="checkbox"
                    name="diffDate"
                    id="diffDate"
                    class="inputs">

                <label for="dateFinished" class="labels">Date Finished:</label>
                <input type="date"
                    name="dateFinished"
                    id="dateFinished"
                    class="inputs"
                    required>

                <label for="dateStarted" class="labels">Date Started:</label>
                <input type="date"
                    name="dateStarted"
                    id="dateStarted"
                    class="inputs">

                <label for="pages" class="labels">Number of Pages:</label>
                <input type="number"
                    name="pages"
                    id="pages"
                    class="inputs"
                    required>

                <label for="ongoing" class="labels">Ongoing:</label>
                <input type="checkbox"
                    name="ongoing"
                    id="ongoing"
                    class="inputs">

                <label for="mod-1" class="labels">Modifier 1:</label>
                <select name="mod-1" id="mod-1" class="inputs">
                    <option value="1">Normal</option>
                    <option value="2">Manga/Comic</option>
                    <option value="3">Challenge</option>
                    <option value="4">Buddy Read</option>
                    <option value="5">Friend Recommendation</option>
                    <option value="6">Seasonal</option>
                    <option value="7">Read-a-thon</option>
                    <option value="8">Educational</option>
                </select>

                <label for="mod-2" class="labels">Modifier 2:</label>
                <select name="mod-2" id="mod-2" class="inputs">
                    <option value="1">Normal</option>
                    <option value="2">Challenge</option>
                    <option value="3">Buddy Read</option>
                    <option value="4">Friend Recommendation</option>
                    <option value="5">Seasonal</option>
                    <option value="6">Read-a-thon</option>
                    <option value="7">Educational</option>
                </select>

                <textarea name="comment" id="comment" class="inputs" placeholder="Any comments about what you read:"></textarea>

                <div class="button-wrapper">
                    <button type="submit" id="updateButton" class="inputs buttons">Update</button>
                </div>

            </form>
        </div>
</body>
</html>