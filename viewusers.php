<?php
session_start();
include("../db_connection.php");

if (!isset($_SESSION['admin_email'])) {
  header("Location: logadmin.php");
  exit();
}

// Update User
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['update_user'])) {
    $id = $_POST['user_id'];
    $name = $_POST['user_name'];
    $email = $_POST['user_email'];

    mysqli_query($conn, "UPDATE user SET name='$name', email='$email' WHERE id=$id");
}

// Update Donor
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['update_donar'])) {
    $email = $_POST['donar_email'];
    $name = $_POST['donar_name'];
    $gender = $_POST['donar_gender'];
    $contact = $_POST['donar_contact'];

    mysqli_query($conn, "UPDATE donarinfo SET name='$name', gender='$gender', contact='$contact' WHERE email='$email'");
}

// Delete User
if (isset($_GET['delete_user'])) {
    $userId = intval($_GET['delete_user']);
    mysqli_query($conn, "DELETE FROM user WHERE id = $userId");
    header("Location: viewusers.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>View Users & Donors</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <style>
    body {
      font-family: 'DM Sans', sans-serif;
      padding: 2rem;
      background-color: #f5f5f5;
    }
    h2 {
      color: #737a5d;
      margin-top: 3rem;
    }
    table {
      background-color: white;
    }
    .btn-back {
      background-color: #737a5d;
      color: white;
      border: none;
      margin-bottom: 1rem;
    }
    .btn-back:hover {
      background-color: #5e674a;
    }
  </style>
</head>
<body>

  <div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="text-primary">View Users & Donors</h1>
    <button class="btn btn-back" onclick="window.location.href='dashboard.php'">Back to Dashboard</button>
  </div>

  <!-- Donar Table -->
  <h2>Donar Information</h2>
  <table class="table table-bordered table-striped">
    <thead class="table-secondary">
      <tr>
        <th>Name</th>
        <th>Gender</th>
        <th>Email</th>
        <th>Contact</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $donarResult = mysqli_query($conn, "SELECT * FROM donarinfo");
      while ($row = mysqli_fetch_assoc($donarResult)) {
        $modalId = "editDonar" . md5($row['email']);
        echo "<tr>
                <td>{$row['name']}</td>
                <td>{$row['gender']}</td>
                <td>{$row['email']}</td>
                <td>{$row['contact']}</td>
                <td>
                  <button class='btn btn-sm btn-primary' data-bs-toggle='modal' data-bs-target='#$modalId'>Edit</button>
                </td>
              </tr>";

        // Donar Edit Modal
        echo "
        <div class='modal fade' id='$modalId' tabindex='-1'>
          <div class='modal-dialog'>
            <div class='modal-content'>
              <form method='POST'>
                <div class='modal-header'>
                  <h5 class='modal-title'>Edit Donor</h5>
                  <button type='button' class='btn-close' data-bs-dismiss='modal'></button>
                </div>
                <div class='modal-body'>
                  <input type='hidden' name='donar_email' value='{$row['email']}'>
                  <div class='mb-3'>
                    <label class='form-label'>Name</label>
                    <input type='text' name='donar_name' value='{$row['name']}' class='form-control' required>
                  </div>
                  <div class='mb-3'>
                    <label class='form-label'>Gender</label>
                    <input type='text' name='donar_gender' value='{$row['gender']}' class='form-control' required>
                  </div>
                  <div class='mb-3'>
                    <label class='form-label'>Contact</label>
                    <input type='text' name='donar_contact' value='{$row['contact']}' class='form-control' required>
                  </div>
                </div>
                <div class='modal-footer'>
                  <button type='submit' name='update_donar' class='btn btn-success'>Update</button>
                  <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancel</button>
                </div>
              </form>
            </div>
          </div>
        </div>";
      }
      ?>
    </tbody>
  </table>

  <!-- User Table -->
  <h2>User Information</h2>
  <table class="table table-bordered table-striped">
    <thead class="table-secondary">
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $userResult = mysqli_query($conn, "SELECT * FROM user");
      while ($row = mysqli_fetch_assoc($userResult)) {
        $modalId = "editUser" . $row['id'];
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['name']}</td>
                <td>{$row['email']}</td>
                <td>
                  <button class='btn btn-sm btn-primary' data-bs-toggle='modal' data-bs-target='#$modalId'>Edit</button>
                  <a href='?delete_user={$row['id']}' onclick=\"return confirm('Are you sure?')\" class='btn btn-sm btn-danger'>Deactivate</a>
                </td>
              </tr>";

        // User Edit Modal
        echo "
        <div class='modal fade' id='$modalId' tabindex='-1'>
          <div class='modal-dialog'>
            <div class='modal-content'>
              <form method='POST'>
                <div class='modal-header'>
                  <h5 class='modal-title'>Edit User</h5>
                  <button type='button' class='btn-close' data-bs-dismiss='modal'></button>
                </div>
                <div class='modal-body'>
                  <input type='hidden' name='user_id' value='{$row['id']}'>
                  <div class='mb-3'>
                    <label class='form-label'>Name</label>
                    <input type='text' name='user_name' value='{$row['name']}' class='form-control' required>
                  </div>
                  <div class='mb-3'>
                    <label class='form-label'>Email</label>
                    <input type='email' name='user_email' value='{$row['email']}' class='form-control' required>
                  </div>
                </div>
                <div class='modal-footer'>
                  <button type='submit' name='update_user' class='btn btn-success'>Update</button>
                  <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancel</button>
                </div>
              </form>
            </div>
          </div>
        </div>";
      }
      ?>
    </tbody>
  </table>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
