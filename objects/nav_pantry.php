<link href="css/nav.scss" rel="stylesheet">

<nav class="navbar navbar-defaults navigation">
    <ul class="nav nav-tabs">
        <li role="presentation"><a href="home.php">
            <span class="glyphicon glyphicon-home" aria-hidden="true"></span>
        </a></li>
        <li role="presentation" class="active clearfix visible-sm visible-md visible-lg"><a href="#">
            Pantry
        </a></li>
        <li class="clearfix visible-sm visible-md visible-lg" role="presentation"><a href="usersshoppinglist.php">
            Shopping List
        </a></li>
        <li class="clearfix visible-sm visible-md visible-lg" role="presentation"><a href="usersrecipe.php">
            Recipes
        </a></li>
        <li class="clearfix visible-sm visible-md visible-lg" role="presentation"><a href="usersavedrecipes.php">
            Saved Recipes
        </a></li>
        <li class="clearfix visible-sm visible-md visible-lg" role="presentation"><a href="usersconversion.php">
            Conversion Chart
        </a></li>
        <li role="presentation" class="dropdown clearfix visible-xs hamburger">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                <span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span>
            </a>
            <ul class="dropdown-menu dropdown">
                <li><a href="usersshoppinglist.php">Shopping List</a></li>
                <li><a href="usersrecipe.php">Recipe</a></li>
                <li><a href="usersavedrecipes.php">Saved Recipes</a></li>
                <li><a href="usersconversion.php">Conversion Chart</a></li>
                <li><a href="usersabout.php">About Us</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="objects/session_destroy.php">Logout</a></li>
            </ul>
        </li>
        <li class="navbar-right clearfix visible-sm visible-md visible-lg" role="presentation"><a href="objects/session_destroy.php">
            Logout
        </a></li>
        <li class="navbar-right clearfix visible-sm visible-md visible-lg" role="presentation"><a href="usersabout.php">
            About Us
        </a></li>
    </ul>
</nav>