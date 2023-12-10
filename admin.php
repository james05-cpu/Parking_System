<?php
include_once("util.php");
include_once("conn.php");
$empty_slots = count(getEmptySlots($conn));
$active_slots = count(getActiveSlots($conn));
$all_slots = $empty_slots + $active_slots;
$history = getHistory($conn);
$users = getUsers($conn);
$transactions = getTransactions($conn);
$qs = getEnq($conn);
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="UTF-8" />
  <title>Admin</title>
  <link rel="stylesheet" href="style.css" />
  <!-- Boxicons CDN Link -->
  <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="refresh" content="60">

</head>

<body>
  <div class="sidebar">
    <div class="logo-details">
      <i class="bx bxl-c-plus-plus icon"></i>
      <div class="logo_name">Mango Park</div>
      <i class="bx bx-menu" id="btn"></i>
    </div>
    <ul class="nav-list">
      <li>
        <a href="#dashboard">
          <i class="bx bx-grid-alt"></i>
          <span class="links_name">Dashboard</span>
        </a>
        <span class="tooltip">Dashboard</span>
      </li>
      
      <li>
        <a href="#enquiry">
          <i class="bx bx-chat"></i>
          <span class="links_name">Enquiry</span>
        </a>
        <span class="tooltip">Enquiry</span>
      </li>
      <li>
        <a href="#history">
          <i class="bx bx-pie-chart-alt-2"></i>
          <span class="links_name">History</span>
        </a>
        <span class="tooltip">History</span>
      </li>
      <li>
        <a href="#users">
          <i class="bx bx-user"></i>
          <span class="links_name">Users</span>
        </a>
        <span class="tooltip">Users</span>
      </li>
      <li>
        <a href="#pay">
          <i class="bx bx-cart-alt"></i>
          <span class="links_name">Transactions</span>
        </a>
        <span class="tooltip">Transactions</span>
      </li>
      <li class="profile">
        <div class="profile-details">
          <img src="profile.jpg" alt="profileImg" />
          <div class="name_job">
            <div class="name">Muthiani JMC</div>
            <div class="job">Copy Writer</div>
          </div>
        </div>
        <i class="bx bx-log-out" id="log_out"></i>
      </li>
    </ul>
  </div>
  <section class="home-section">
    <div class="text" id="dashboard">Dashboard</div>

    <div class="card-holder">
      <div class="card">
        <div class="card-title">No. Of Slots</div>
        <div class="card-text" id="all_slots"><?php echo ($all_slots); ?></div>
      </div>
      <div class="card">
        <div class="card-title" >Occupied Slots</div>
        <div class="card-text"id="active_slots"><?php echo ($active_slots); ?></div>
      </div>
      <div class="card">
        <div class="card-title" >Empty Slots</div>
        <div class="card-text"id="empty_slots"><?php echo ($empty_slots); ?></div>
      </div>
    </div>

    <table>
      <caption id="history">History</caption>
      <thead>
        <tr>
          <th scope="col">Date</th>
          <th scope="col">Slot</th>
          <th scope="col">User</th>
          <th scope="col">Time in</th>
          <th scope="col">Time out</th>

        </tr>
      </thead>
      <tbody>
        <?php
        foreach ($history as $data) {

        ?>
          <tr>
            <td data-label="Date"><?php echo ($data["date"]); ?></td>
            <td data-label="Slot"><?php echo ($data["slot"]); ?></td>
            <td data-label="User"><?php echo ($data["user_email"]); ?></td>
            <td data-label="Time in"><?php echo ($data["time_in"]); ?></td>
            <td data-label="Time out"><?php echo ($data["time_out"]); ?></td>
          </tr>
        <?php
        }
        ?>
      </tbody>
    </table>
    
    <table>
      <caption id="enquiry">Enquery</caption>
      <thead>
        <tr>
          <th scope="col">Time</th>
          <th scope="col">Email</th>
          <th scope="col">Message</th>
        </tr>
      </thead>
      <tbody>
        <?php
        foreach ($qs as $q) {
        ?>
          <tr>
            <td data-label="Time"><?php echo ($q["time"]); ?></td>
            <td data-label="Email"><?php echo ($q["email"]); ?></td>
            <td data-label="Message"><?php echo ($q["message"]); ?></td>
          </tr>
        <?php
        }
        ?>
      </tbody>
    </table>
    <table>
      <caption id="users">Users</caption>
      <thead>
        <tr>
          <th scope="col">Name</th>
          <th scope="col">Email</th>
        </tr>
      </thead>
      <tbody>
      <?php
        foreach ($users as $user) {

        ?>
          <tr>
            <td data-label="Time"><?php echo ($user["fname"]); ?></td>
            <td data-label="Email"><?php echo ($user["email"]); ?></td>
          </tr>
        <?php
        }
        ?>

      </tbody>
    </table>
    <table>
      <caption id="pay">Transactions</caption>
      <thead>
        <tr>
          <th scope="col">Date</th>
          <th scope="col">Email</th>
          <th scope="col">Plan</th>
          <th scope="col">Amount</th>
          <th scope="col">Status</S></th>
          <th scope="col">Slot</S></th>

        </tr>
      </thead>
      <tbody>
        <?php
        foreach ($transactions as $data) {

        ?>
          <tr>
            <td data-label="Date"><?php echo ($data["date"]); ?></td>
            <td data-label="Email"><?php echo ($data["email"]); ?></td>
            <td data-label="Plan"><?php echo ($data["plan"]); ?></td>
            <td data-label="Amount"><?php echo ($data["amount"]); ?></td>
            <td data-label="Status"><?php echo ($data["status"]); ?></td>
            <td data-label="Slot"><?php echo ($data["slot_label"]); ?></td>
          </tr>
        <?php
        }
        ?>
      </tbody>
    </table>
  </section>
  <script src="script.js"></script>
</body>

</html>