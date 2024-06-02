<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospitality Management System</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Welcome to Grand Hotel</h1>
        <form action="index.php" method="post">
            <label for="guest_name">Guest Name:</label>
            <input type="text" id="guest_name" name="guest_name" required>
            <input type="submit" name="book" value="Book Room">
        </form>
        <form action="index.php" method="post">
            <label for="room_number">Room Number:</label>
            <input type="number" id="room_number" name="room_number" required>
            <input type="submit" name="checkout" value="Check Out">
        </form>
        <h2>Room Status</h2>
        <div class="room-status">
            <?php
            session_start();

            if (!isset($_SESSION['rooms'])) {
                $_SESSION['rooms'] = array_fill(1, 5, ['available' => true, 'guest_name' => null]);
            }

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                if (isset($_POST['book'])) {
                    $guest_name = $_POST['guest_name'];
                    bookRoom($guest_name);
                } elseif (isset($_POST['checkout'])) {
                    $room_number = $_POST['room_number'];
                    checkOutRoom($room_number);
                }
            }

            function bookRoom($guest_name) {
                foreach ($_SESSION['rooms'] as $room_number => $room) {
                    if ($room['available']) {
                        $_SESSION['rooms'][$room_number] = ['available' => false, 'guest_name' => $guest_name];
                        echo "<p>Room $room_number has been booked by $guest_name.</p>";
                        return;
                    }
                }
                echo "<p>No available rooms to book.</p>";
            }

            function checkOutRoom($room_number) {
                if (isset($_SESSION['rooms'][$room_number])) {
                    $_SESSION['rooms'][$room_number] = ['available' => true, 'guest_name' => null];
                    echo "<p>Room $room_number has been checked out.</p>";
                } else {
                    echo "<p>Invalid room number.</p>";
                }
            }

            foreach ($_SESSION['rooms'] as $room_number => $room) {
                $status = $room['available'] ? 'available' : 'booked by ' . $room['guest_name'];
                $class = $room['available'] ? 'available' : 'booked';
                echo "<div class='room $class'>Room $room_number is $status.</div>";
            }
            ?>
        </div>
    </div>
</body>
</html>