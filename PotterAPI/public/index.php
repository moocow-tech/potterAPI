<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<label for="search">Search Name</label>
<input type="text" name="search" id="search">
<input type="submit">
</form>
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<label for="search">Choose House</label>
<select name="house" id="house">
  <option value="Hufflepuff">Hufflepuff</option>
  <option value="Gryffindor">Gryffindor</option>
  <option value="Slytherin">Slytherin</option>
  <option value="Ravenclaw">Ravenclaw</option>
</select>
<input type="submit" >
</form>
<?php
/**
 * Simple Script to fetch data from
 * the PotterAPI
 *
 */
require '../configuration.php';
$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://www.potterapi.com/v1/characters/?key=' . $key,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
        "Cookie: __cfduid=dbc31d321c729714bb6d988a6667411e61595791484",
    ),
));

$response = curl_exec($curl);

curl_close($curl);
$character = json_decode($response);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['search'])) {
        $search = $_POST['search'];
        foreach ($character as $key => $val) {
            if (stripos($val->name, $search) !== false) {
                echo '<div style="float:left; width:25%; padding: 5px;"><h3>' . $val->name . '</h3>';
                if (isset($val->house)) {
                    echo '<p>' . $val->house . '</p>';
                }
                if (isset($val->role)) {
                    echo '<p>' . $val->role . '</p>';
                }
                echo '<p>' . $val->species . '</p></div>';
            }
        }
    } elseif (isset($_POST['house'])) {
        foreach ($character as $key => $val) {
            $house= $_POST['house'];
            if (isset($val->house) && $val->house == $house ) {
                echo '<div style="float:left; width:25%; padding: 5px;"><h3>' . $val->name . '</h3><p>' . $val->house . '</p>';
                if (isset($val->role)) {
                    echo '<p>' . $val->role . '</p>';
                }
                echo '<p>' . $val->species . '</p></div>';
            }
        }
    }
} else {
    foreach ($character as $key => $val) {
        echo '<div style="float:left; width:25%; padding: 5px;"><h3>' . $val->name . '</h3>';
        if (isset($val->house)) {
            echo '<p>' . $val->house . '</p>';
        }
        if (isset($val->role)) {
            echo '<p>' . $val->role . '</p>';
        }
        echo '<p>' . $val->species . '</p></div>';
    }
}
?>

  </body>
</html>