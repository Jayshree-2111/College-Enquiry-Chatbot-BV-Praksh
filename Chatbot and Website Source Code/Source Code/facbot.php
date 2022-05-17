<!-- php start for bot-->
<!-- step 1 => create database for response and user messages -->
<!-- step 2 => create a connection -->

<?php
// server = localhost
// username = root
// password = "" (blank)
// database Name = your database name

$conn = mysqli_connect("localhost", "root", "", "onlinebot");

if ($conn) {
    $user_messages = mysqli_real_escape_string($conn, $_POST['messageValue']);

    $query = "SELECT * FROM facultybot WHERE messages LIKE '%$user_messages%'";
    $runQuery = mysqli_query($conn, $query);

    if (mysqli_num_rows($runQuery) > 0) {
        // fetch result
        $result = mysqli_fetch_assoc($runQuery);
        // echo result
        echo $result['response'];
    } else {
        echo "Sorry can't find your query!<br/><br/>Choose the appropriate word for your query:<br><br>- Market<br>- Room/Stay/Home<br>- Departments/Classes/Courses<br>- Ragging/ Sexual Harassment<br>- Dress<br>- Canteens<br>- Hospital<br>- Bank<br>- Post Office<br>- Library<br>- Calendar<br>- Guest House<br>- Administration Related Queries<br>- Sports<br>- Fest<br>- Festivals<br/><br/>If you can't find your query here, please fill the form: <a href='https://forms.gle/emZHLbuSsGMWRyNf8' style='text-decoration: none; color: white'> <u>Click to add your query</u></a>";
    }
} else {
    echo "connection Failed " . mysqli_connect_errno();
}
?>