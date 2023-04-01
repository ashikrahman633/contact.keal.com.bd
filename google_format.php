<?php include_once("classes/PhoneBook.php"); ?>
<?php
$dateTime = date_default_timezone_set('Asia/Dhaka');
$date = date("Y-m-d");
$day = date("(D)");
$timestamp = time();
$time = date("H:i:s", $timestamp);
$ip = $_SERVER['REMOTE_ADDR'];

?>
<?php
$pb = new PhoneBook();
$db = new Database();
$fm = new Format();
?>

<?php
if (isset($_GET['vis'])) {
  $vis = $_GET['vis'];
} else {
  $vis = 0;
}
if (isset($_GET['cg_id'])) {
  $contact_group_id = $_GET['cg_id'];
} else {
  $contact_group_id = 0;
}
?>
<?php
$pq = "SELECT * FROM tbl_my_contact_group WHERE id = '$contact_group_id'";
$pr = $db->select($pq);
if ($pr) {
  $prdata = $pr->fetch_assoc();
  $group_name = $prdata['group_name'];
}
?>

<!DOCTYPE html>
<html lang="en">

<>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $group_name ?> | Contacts</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
  </head>

  <body>
    <h1 style="text-align: center;">Contacts in Google Format</h1>
    <p style="text-align: center;">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="./index.php">Home</a></li>
        <li class="breadcrumb-item"><a href="./all_contacts.php">All Contacts</a></li>
        <li class="breadcrumb-item"><a href="./contact_group.php">My Contact Groups</a></li>
        <li class="breadcrumb-item active" aria-current="page">Google Export</li>
      </ol>
    </nav>
    </p>
    <hr>
    <div class="table-responsive">
      <table id="example" class="display nowrap" style="width:100%">
        <thead>
          <tr>
            <th>Name</th>
            <th>Given Name</th>
            <th>Additional Name</th>
            <th>Family Name</th>
            <th>Yomi Name</th>
            <th>Given Name Yomi</th>
            <th>Additional Name Yomi</th>
            <th>Family Name Yomi</th>
            <th>Name Prefix</th>
            <th>Name Suffix</th>
            <th>Initials</th>
            <th>Nickname</th>
            <th>Short Name</th>
            <th>Maiden Name</th>
            <th>Birthday</th>
            <th>Gender</th>
            <th>Location</th>
            <th>Billing Information</th>
            <th>Directory Server</th>
            <th>Mileage</th>
            <th>Occupation</th>
            <th>Hobby</th>
            <th>Sensitivity</th>
            <th>Priority</th>
            <th>Subject</th>
            <th>Notes</th>
            <th>Language</th>
            <th>Photo</th>
            <th>Group Membership</th>
            <th>Phone 1 - Type</th>
            <th>Phone 1 - Value</th>
            <th>Phone 2 - Type</th>
            <th>Phone 2 - Value</th>
            <th>Phone 3 - Type</th>
            <th>Phone 3 - Value</th>
            <th>Organization 1 - Type</th>
            <th>Organization 1 - Name</th>
            <th>Organization 1 - Yomi Name</th>
            <th>Organization 1 - Title</th>
            <th>Organization 1 - Department</th>
            <th>Organization 1 - Symbol</th>
            <th>Organization 1 - Location</th>
            <th>Organization 1 - Job Description</th>
          </tr>
        </thead>


        <tbody>
          <?php
          $sql = $db->select("SELECT * FROM my_google_contacts WHERE group_id = '$contact_group_id'");
          if ($sql) {
            foreach ($sql as $value) {
              $contact_id = $value['contact_id'];
              $position_id = $value['position_id'];
              $workplace_id = $value['workplace_id'];

          ?>
              <?php
              $ssqls = $db->select("SELECT * FROM tbl_contact_book WHERE id = '$contact_id'");
              if ($ssqls) {
                $values = $ssqls->fetch_assoc();
                $mobile_id = $values['mobile_id'];
                $personal_mobile_id = $values['personal_mobile_id'];
                $email_id = $values['email_id'];
                $prefix_id = $values['prefix_id'];
                $suffix_id = $values['suffix_id'];
                $nick_name_id = $values['nick_name_id'];
                $short_name = $values['short_name'];
                $dob = $values['dob'];
                $gender_id = $values['gender_id'];

                $mobileq = $db->select("SELECT * FROM tbl_prefix WHERE id = '$prefix_id' AND id <> '1' AND id <> '2'");
                if ($mobileq) {
                  $mobdata = $mobileq->fetch_assoc();
                  $prefix = $mobdata['prefix'];
                } else {
                  $prefix = '';
                }
              }
              ?>
              <tr>
                <td>
                  <?php
                  // $gcf = $pb->getContact($contact_id);
                  // if ($gcf) {
                  //   $row = $gcf->fetch_assoc();
                  //   echo $prefix . ' ' . $row['name'];
                  // }
                  ?>
                </td>
                <td>
                  <?php
                  $gcf = $pb->getContact($contact_id);
                  if ($gcf) {
                    $row = $gcf->fetch_assoc();
                    echo $row['name'];
                  }
                  ?>
                </td>
                <td></td>
                <td>
                  <!-- Membership Number -->
                  <?php
                  $mafq = $db->select("SELECT * FROM tbl_my_affilation WHERE user_id = '$contact_id'");
                  if ($mafq) {
                    $mafdata = $mafq->fetch_assoc();
                    echo $mafdata['member_number'];
                  } else {
                    echo '';
                  }
                  ?>
                </td>
                <td></td>
                <td>
                  <!-- Label / Group Name -->
                  <?= $group_name ?>
                </td>
                <td></td>
                <td>
                  <!-- Membership Number -->
                  <?php
                  $mafq = $db->select("SELECT * FROM tbl_my_affilation WHERE user_id = '$contact_id'");
                  if ($mafq) {
                    $mafdata = $mafq->fetch_assoc();
                    echo $mafdata['member_number'];
                  } else {
                    echo '';
                  }
                  ?>
                </td>
                <td>
                  <?php
                  $mobileq = $db->select("SELECT * FROM tbl_prefix WHERE id = '$prefix_id' AND id <> '1' AND id <> '2'");
                  if ($mobileq) {
                    $mobdata = $mobileq->fetch_assoc();
                    echo $mobdata['prefix'];
                  }
                  ?>
                </td>
                <td>
                  <?php
                  $mobileq = $db->select("SELECT * FROM tbl_suffix WHERE id = '$suffix_id'");
                  if ($mobileq) {
                    $mobdata = $mobileq->fetch_assoc();
                    echo $mobdata['suffix'];
                  }
                  ?>
                </td>
                <td></td>
                <td>
                  <?php
                  $mobileq = $db->select("SELECT * FROM tbl_nickname WHERE id = '$nick_name_id'");
                  if ($mobileq) {
                    $mobdata = $mobileq->fetch_assoc();
                    echo $mobdata['nickname'];
                  }
                  ?>
                </td>
                <td><?= $short_name ?></td>
                <td></td>
                <td><?= $dob ?></td>
                <td>
                  <?php
                  $mobileq = $db->select("SELECT * FROM tbl_gender WHERE id = '$gender_id'");
                  if ($mobileq) {
                    $mobdata = $mobileq->fetch_assoc();
                    echo $mobdata['gender'];
                  }
                  ?>
                </td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>
                  <?php
                  $mobileq = $db->select("SELECT * FROM tbl_mobile WHERE id = '$mobile_id'");
                  if ($mobileq) {
                    $mobdata = $mobileq->fetch_assoc();
                    $country_id = $mobdata['country_id'];
                    $mobile = $mobdata['mobile'];

                    $conq = $db->select("SELECT * FROM tbl_country WHERE id = '$country_id'");
                    if ($conq) {
                      $condata = $conq->fetch_assoc();
                      $telCode = $condata['telCode'];

                      echo $telCode . $mobile;
                    }
                  }
                  ?>
                </td>
                <td></td>
                <td>
                  <?php
                  $pmobileq = $db->select("SELECT * FROM tbl_mobile WHERE id = '$personal_mobile_id'");
                  if ($pmobileq) {
                    $pmobdata = $pmobileq->fetch_assoc();
                    $pcountry_id = $pmobdata['country_id'];
                    $pmobile = $pmobdata['mobile'];

                    $pconq = $db->select("SELECT * FROM tbl_country WHERE id = '$pcountry_id'");
                    if ($pconq) {
                      $pcondata = $pconq->fetch_assoc();
                      $ptelCode = $pcondata['telCode'];

                      echo $ptelCode . $pmobile;
                    }
                  }
                  ?>
                </td>
                <td></td>
                <td></td>
                <td></td>
                <td>
                  <?php
                  $mobileq = $db->select("SELECT * FROM tbl_workplace WHERE id = '$workplace_id'");
                  if ($mobileq) {
                    $mobdata = $mobileq->fetch_assoc();
                    echo $mobdata['workplace_name'];
                  }
                  ?>
                </td>
                <td></td>
                <td>
                  <?php
                  $mobileq = $db->select("SELECT * FROM tbl_possition WHERE id = '$position_id'");
                  if ($mobileq) {
                    $mobdata = $mobileq->fetch_assoc();
                    echo $mobdata['possition_name'];
                  }
                  ?>
                </td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>


              </tr>
          <?php
            }
          }
          ?>
        </tbody>

      </table>
    </div>
    <!-- Datatable -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>

    <script type="text/javascript">
      // $(function () {
      //     $('#example').DataTable( {
      //         "ordering": true
      //     } );
      //   } );
      $(document).ready(function() {
        $('#example').DataTable({
          dom: 'Bfrtip',
          buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
          ]
        });
      });
    </script>
  </body>

</html>