<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
$baseURL = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/php-project/views/admin';
include '../../core/functions.php';
include '../../core/students.php';

$data = getList();
// $data = [
//     ['id' => 1, 'name' => 'John Doe', 'email' => 'john@example.com'],
//     ['id' => 2, 'name' => 'Jane Smith', 'email' => 'jane@example.com']
// ];

// print_r($data);
// exit();
session_start();
redirect_if_not_logged_in();
include '../../includes/header.php';


?>
<div class="content-wrapper container">
    <br>


    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
        Add
    </button>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">First</th>
      <th scope="col">Last</th>
      <th scope="col">Handle</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">1</th>
      <td>Mark</td>
      <td>Otto</td>
      <td>@mdo</td>
    </tr>
    <tr>
      <th scope="row">2</th>
      <td>Jacob</td>
      <td>Thornton</td>
      <td>@fat</td>
    </tr>
    <tr>
      <th scope="row">3</th>
      <td>Larry</td>
      <td>the Bird</td>
      <td>@twitter</td>
    </tr>
  </tbody>
</table>

</div>
<?php include '../../includes/footer.php'; ?>