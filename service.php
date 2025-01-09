
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "car_moto_service";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
  </head>
  <body>
    <header>
      <nav>
        <img src="./img/logo-tech-mec.png" alt="" />
        <a href="index.html">Home</a>
        <ul>
          <li>
            Your vehicle <br />
            Our priority
          </li>
          <li>About us</li>
          <li><a href="service.html">Our services</a></li>
        </ul>
      </nav>
    </header>
    <form action="service.php" method="POST">
      <input type="radio" id="Car" name="car_radio" value="HTML" />
      <label for="Car">Car</label><br />
      <input type="radio" id="Moto" name="moto_radio" value="HTML" />
      <label for="Moto">Moto</label><br />
      Date: <input type="date" name="date" /><br />
      Brand: <input type="text" name="brand" /><br />
      Model
      <select id="brand_picker" name="brands">
        <?php include 'booking.php'; ?>
      </select>
        </option>
      </select>
      <br />
      Registration: <input type="text" name="registration" /><br />
      <label for="subject">Description</label>
      <textarea
        id="description"
        name="description"
        placeholder="Write something.."
        style="height: 200px"
      ></textarea>
      <p>Required service(s):</p>
      <input type="checkbox" id="task1" name="vehicle1" value="task1" />
      <label for="task1"> Technical check</label><br />
      <input type="checkbox" id="task2" name="task2" value="task2" />
      <label for="task2"> Wash</label><br />
      <input type="checkbox" id="task3" name="task3" value="task3" />
      <label for="task3"> Tyre change</label><br />
      <button type="submit" class="registerbtn">Submit</button>
    </form>
    <?php
// this checks if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $vehicleType = isset($_POST['car_radio']) ? 'Car' : (isset($_POST['moto_radio']) ? 'Moto' : '');
    $date = $_POST['date'];
    $brand = $_POST['brand'];
    $model = $_POST['brands'];
    $registration = $_POST['registration'];
    $description = $_POST['description'];

    $services = [];
    if (isset($_POST['task1'])) $services[] = "Technical check";
    if (isset($_POST['task2'])) $services[] = "Wash";
    if (isset($_POST['task3'])) $services[] = "Tyre change";

  
    $stmt = $conn->prepare("INSERT INTO bookings (vehicle_type, brand, model, registration, description, services, date) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $vehicleType, $date, $brand, $model, $registration, $description, $servicesString);

    if ($stmt->execute()) {
        echo "Booking successfully saved!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

?>
  </body>
</html>
