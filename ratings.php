<?php

if(!isset($_GET['rating'])) {
    header('Location: search.php');
}

$rating = $_GET['rating'];

$host = 'itp460.usc.edu';
$dbname = 'dvd';
$user = 'student';
$pass = 'ttrojan';

$pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);

$sql = "
    SELECT title, format_name, genre_name, rating_name
    FROM dvds
    INNER JOIN formats ON dvds.format_id = formats.id 
    INNER JOIN genres ON dvds.genre_id = genres.id
    INNER JOIN ratings ON dvds.rating_id = ratings.id
    WHERE rating_name = ?
";

$statement = $pdo->prepare($sql);
$statement->bindParam(1, $rating);
$statement->execute();
$movies = $statement->fetchAll(PDO::FETCH_OBJ);

?>

<?php foreach($movies as $movie) : ?>
    <div>
        <?php echo $movie->title ?> of genre <?php echo $movie->genre_name ?> in <?php echo $movie->format_name ?> format with a rating of
        <a href ="ratings.php?rating=<?php echo $movie->rating_name ?>">
            <?php echo $movie->rating_name ?>
        </a>
    </div>
    <br>
<?php endforeach ?>