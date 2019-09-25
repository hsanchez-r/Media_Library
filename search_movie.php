<?php
/***
 * Author: Hector Sanchez
 * Date: 9/14/2019
 * File: search_movie.php
 * Description: this file will retrieve search terms from the search box;
 * it then passes the search terms to the movie manager to get all matched movies in an array
 */
//Functions below are used to include PHP files between parentheses into this file
require_once ('classes/movie_manager.class.php');
require_once ('classes/search_movie.class.php');

//Below I have created the MovieManager
$movie_manager = MovieManager:: getMovieManager();

//Below in order to sanitize code for security purposes I used an if
if (filter_has_var(INPUT_GET, "query-terms")) {
    $terms = filter_input(INPUT_GET, "query-terms", FILTER_SANITIZE_STRING);
}
//Below I created a variable that it's able to retrieve movies from terms variable
$movies = $movie_manager->search_movie($terms);

//Below the if it's for handling errors
if (!$movies) {
    $message = "There was a problem displaying movies.";
    header("Location: show_error.php?eMsg=$message");
    exit();
}

// Contributes to display all movies
$view = new SearchMovie();
$view->display($movies, $terms);
?>