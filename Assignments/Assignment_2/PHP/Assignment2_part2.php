<?php
setcookie('lastVisit', time(), time() + 60 * 60 * 24 * 5);

if (isset($_COOKIE['lastVisit'])) {
    $lastVisit = $_COOKIE['lastVisit'];
    echo "Current visit: " . date('D, d-m-Y') . "<br>";
    echo "Last visit: " . date('D, d-m-Y', $last_visit) . "<br>";
} else {
    echo "Current visit: " . date('D, d-m-Y') . "<br>";


}


//Add at least 10 entries in the array
$album["pic.jpg"] = [50, 30, "icon", "No URL"];
$album["pic2.jpg"] = [200, 300, "thumbnail", "http://www.abc.com"];
$album["pic3.jpg"] = [200, 300, "thumbnail", "http://www.uob.edu.bh"];
$album["pic4.jpg"] = [200, 300, "thumbnail", "http://www.google.com"];
$album["pic5.jpg"] = [200, 300, "thumbnail", "http://www.yahoo.com"];
$album["pic6.jpg"] = [200, 300, "thumbnail", "http://www.bing.com"];
$album["pic7.jpg"] = [200, 300, "thumbnail", "http://www.facebook.com"];
$album["pic8.jpg"] = [200, 300, "thumbnail", "http://www.twitter.com"];
$album["pic9.jpg"] = [200, 300, "thumbnail", "http://www.instagram.com"];
$album["pic10.jpg"] = [200, 300, "thumbnail", "http://www.linkedin.com"];

//Write PHP statements that displays all thumbnails pictures only according to their  dimensions (width/height) and make them clickable as hyperlinks to the URL defined in  its URL’s value
echo "<table border='1'>";
echo "<tr><th>Picture</th>";
//<th>Width</th><th>Height</th><th>Icon</th><th>URL</th></tr>";
foreach ($album as $key => $value) {
    if ($value[2] == "thumbnail") {
        echo "<tr><td><a href='$value[3]'><img src='Pictures/$key' width='$value[0]' height='$value[1]'></a>";
        //</td><td>$value[0]</td><td>$value[1]</td><td>$value[2]</td><td>$value[3]</td></tr>";
    }
}
echo "</table>";

?>