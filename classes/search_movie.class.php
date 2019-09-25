<?php
/***
 * Author: Hector Sanchez Riveras
 * Date: 9/14/2019
 * File: search_movie.class.php
 * Description: class that allow to connect to the database, explode terms in an array and display the movies in a grid
 */
//The function below was  used to include the app.view.class file into this one
require_once ('application/app_view.class.php');
require_once ('movie_manager.class.php');
require_once ('movie.class.php');

//Below I have created the search movie class
class SearchMovie{

    public function display($movies, $terms)
    {
        AppView::displayHeader("List All Movies");
        ?>

        <div id="main-header"> Search results for <?php echo $terms ?></div>
        <div class="grid-container">
            <?php
            $db = Database::getDatabase();
            $terms = explode(" ", " "); //explode multiple terms into an array
            //select statement for an AND search
            $sql = "SELECT * FROM " . $db->getMovieTable() . "," . $db->getMovieRatingTable() .
                " WHERE " . $db->getMovieTable() . ".rating=" . $db->getMovieRatingTable() . ".rating_id AND (1";

            foreach ($terms as $term) {
                $sql .= " AND title LIKE '%" . $term . "%'";
            }
            $sql .= ")";
            if ($movies === 0) {
                echo "No movie was found.<br><br><br><br><br>";
            } else {
                //Below the foreach loop helps to display the movies in a grid. Will be 6 in a row
                foreach ($movies as $i => $movie) {
                    $id = $movie->getId();
                    $title = $movie->getTitle();
                    $rating = $movie->getRating();
                    $release_date = $release_date = new DateTime($movie->getRelease_date());
                    $image = $movie->getImage();
                    if (strpos($image, "http://") === false AND strpos($image, "https://") === false) {
                        $image = MOVIE_IMG . $image;
                    }
                    if ($i % 6 == 0) {
                        echo "<div class='row'>";
                    }
                    echo "<div class='col'><p><a href='view_movie.php?id=" . $id . "'><img src='" . $image .
                        "'></a><span>$title<br>Rated $rating<br>" . $release_date->format('m-d-Y') . "</span></p></div>";
                    ?>
                    <?php
                    if ($i % 6 == 5 || $i == count($movies) - 1) {
                        echo "</div>";
                    }
                }
            }
            ?>
        </div>
        <?php
        AppView::displayFooter();
    }
}