<!DOCTYPE HTML>
<html>
       <head>
          <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
          <title>Test task for Zimalab</title>

           <link rel = "stylesheet" href="style.css">
           <script src = "functions.js"></script>

       </head>
  <body>
  <center>
      <h1>Client accounts</h1>

      <div class="pager">
  <?php
  //Pagination
  $page_size = 10; //Pagination size

  require_once 'connection.php'; //Database connection

  $num_records = mysqli_fetch_array(mysqli_query($db_link, 'SELECT COUNT(*) FROM accounts'))[0]; //Get count of records in DB
  $num_pages = intdiv($num_records, $page_size) + 1; //Get count of pages

  $page = $_REQUEST['page'] ?? 1;
  if ($page < 1) {
      $page = 1;
  } else if ($page > $num_pages) {
      $page = $num_pages;
  }
  $offset = ($page - 1) * $page_size;

  echo 'Page: ';
  function page_link($num, $current) {
      if ($num == $current) {
          echo '<div class="page">' . $num . '</div>';
      } else {
          echo '<div class="page"><a href="?page='.$num.'">'.$num.'</a></div>';
      }
  }
  function multipage($start, $end, $current) {
      for ($i = $start; $i < $end; $i++) {
          page_link($i, $current);
      }
  }

  $page_delta = 2; //Uses for creating dots between pages when page count is big

  $start = $page - $page_delta;
  $end = $page + $page_delta + 1;
  if ($start < 1) {
      $start = 1;
  }
  if ($end > $num_pages) {
      $end = $num_pages + 1;
  }
  if ($start > 1) {
      page_link(1, $page);
      if ($start > 2) {
          echo '<div class="dots">...</div>';
      }
  }
  multipage($start, $end, $page);
  if ($end <= $num_pages) {
      if ($num_pages - $end > 0) {
          echo '<div class="dots">...</div>';
      }
      page_link($num_pages, $page);
  }
  ?>
      </div>
  <br>
            <!-- Creating headers of table -->
            <table border = 1>
                <thead>
                <tr>
                    <th>id</th>
                    <th>first name</th>
                    <th>last name</th>
                    <th>email</th>
                    <th>company</th>
                    <th>position</th>
                    <th>phone1</th>
                    <th>phone2</th>
                    <th>phone3</th>
                    <th>action</th>
                </tr>
                </thead>
                <tbody>


   <?php
      // Accounts data output from DB
      $query = "SELECT * FROM accounts ORDER BY id ASC LIMIT $page_size OFFSET $offset";
      $result = mysqli_query($db_link, $query) or die ("Error: ".mysqli_error($db_link));
      if ($result)
      {
          while ($data = mysqli_fetch_array($result)){
              $id = $data['id'];
              echo '<tr>';
                echo '<td>'.$id.'</td>';
                echo '<td><input id="fname'.$id.'" value="'.$data['fname'].'" class="name" onchange="mkValid(this)"/></td>';
                echo '<td><input id="lname'.$id.'" value="'.$data['lname'].'" class="name" onchange="mkValid(this)"/></td>';
                echo '<td><input type="text" id="email'.$id.'" value="'.$data['email'].'" class="email" onchange="mkValid(this)"/></td>';
                echo '<td><input id="company'.$id.'" value="'.$data['company'].'" class="misc"/></td>';
                echo '<td><input id="position'.$id.'" value="'.$data['position'].'" class="misc"/></td>';
                echo '<td><input id="phone1_'.$id.'" value="'.$data['phone1'].'" class="misc" onchange="mkValid(this)"/></td>';
                echo '<td><input id="phone2_'.$id.'" value="'.$data['phone2'].'" class="misc" onchange="mkValid(this)"/></td>';
                echo '<td><input id="phone3_'.$id.'" value="'.$data['phone3'].'" class="misc" onchange="mkValid(this)"/></td>';
                echo '<td>
                        <input type="button" value="Update" onclick="update('.$id.');" />
                        <input type="button" value="Delete" onclick="remove('.$id.');" />
                      </td>';
              echo '</tr>';
          }

        mysqli_free_result($result);
      }
   mysqli_close($db_link);

   ?>
            </tbody>
            </table>
    <br>

    <!-- Creating form for adding new accounts entry -->
    <form>
            <div class="form_cr">
            <strong>Create new account:</strong>
            </div>

        <div class="add_form">
            <label for="fname">First name</label>
            <input type="text" required minlength="1" maxlength="50" id="fname" onchange="mkValid(this)">
        </div>

        <div class="add_form">
            <label for="lname">Last name</label>
            <input type="text" required minlength="1" maxlength="100" id="lname" onchange="mkValid(this)">
        </div>

        <div class="add_form">
            <label for="email">Email</label>
            <input type="email" required minlength="1" maxlength="100" id="email" onchange="mkValid(this)">
        </div>

        <div class="add_form">
            <label for="company">Company</label>
            <input type="text" maxlength="100" id="company">
        </div>

        <div class="add_form">
            <label for="position">Position</label>
            <input type="text" maxlength="50" id="position">
        </div>

        <div class="add_form">
            <label for="phone1">Phone 1</label>
            <input type="text" maxlength="20" id="phone1" onchange="mkValid(this)">
        </div>

        <div class="add_form">
            <label for="phone2">Phone 2</label>
            <input type="text" maxlength="20" id="phone2" onchange="mkValid(this)">
        </div>

        <div class="add_form">
            <label for="phone3">Phone 3</label>
            <input type="text" maxlength="20" id="phone3" onchange="mkValid(this)">
        </div>

        <div class="button">
            <input type="button" value="Add account" id="button_add" onclick="add();">
        </div>


    </form>
        </center>


  </body>
</html>