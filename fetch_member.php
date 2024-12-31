<?php
include 'database.php'; // Include the database connection file

$sql = "SELECT id, full_name, created_at, contact_no, email FROM users";
$result = $con->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['full_name'] . "</td>";
        echo "<td>" . $row['created_at'] . "</td>";
        echo "<td>" . $row['contact_no'] . "</td>";
        echo "<td>" . $row['email'] . "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='5'>No members found</td></tr>";
}

$con->close();
?>
