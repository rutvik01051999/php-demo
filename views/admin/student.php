<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
$baseURL = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/php-project/views/admin';
include '../../core/functions.php';
session_start();
redirect_if_not_logged_in();
include '../../includes/header.php';


?>
<div class="content-wrapper container">
  <div class="container mt-5">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
      Add
    </button><br><br>

    <!-- Table to display user data -->
    <table class="table table-bordered" id="usersTable">
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Email</th>
          <th>Created At</th>
        </tr>
      </thead>
      <tbody>
        <!-- Data will be loaded dynamically here -->
      </tbody>
    </table>

    <!-- Pagination controls -->
    <nav id="paginationNav">
      <ul class="pagination">
        <!-- Pagination buttons will be inserted here -->
      </ul>
    </nav>
  </div>




</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Student</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="dataForm">
          <div>Student Detail</div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="inputEmail4">Email</label>
              <input type="email" class="form-control" name="email" id="inputEmail4" placeholder="Email">
            </div>
            <div class="form-group col-md-6">
              <label for="mobile">Mobile</label>
              <input type="number" name="mobile" class="form-control" id="mobile" placeholder="Mobile">
            </div>
          </div>
          <div>Current Address</div>
          <div class="form-group">
            <label for="inputAddress_current">Address</label>
            <input type="text" name="inputAddress_current"  class="form-control" id="inputAddress_current" placeholder="1234 Main St">
          </div>
          <div class="form-group">
            <label for="inputAddress2_current">Address 2</label>
            <input type="text" name="inputAddress2_current" class="form-control" id="inputAddress2_current" placeholder="Apartment, studio, or floor">
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="inputCity_current">City</label>
              <input type="text" name="inputCity_current" class="form-control" id="inputCity_current">
            </div>
            <div class="form-group col-md-4">
              <label for="inputState_current">State</label>
              <select id="inputState_current" name="inputState_current" class="form-control">
                <option selected>Choose...</option>
                <option>GJ</option>
              </select>
            </div>
            <div class="form-group col-md-2">
              <label for="inputZip_current">Zip</label>
              <input type="text" name="inputZip_current" class="form-control" id="inputZip_current">
            </div>
          </div>

          <div>Permanent Address</div>
          <div class="form-group">
            <label for="inputAddress_permanent">Address</label>
            <input type="text" name="inputAddress_permanent" class="form-control" id="inputAddress_permanent" placeholder="1234 Main St">
          </div>
          <div class="form-group">
            <label for="inputAddress2_permanent">Address 2</label>
            <input type="text" name="inputAddress2_permanent" class="form-control" id="inputAddress2_permanent" placeholder="Apartment, studio, or floor">
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="inputCity_permanent">City</label>
              <input name="inputCity_permanent" type="text" class="form-control" id="inputCity_permanent">
            </div>
            <div class="form-group col-md-4">
              <label for="inputState_permanent">State</label>
              <select id="inputState_permanent" name = "inputState_permanent" class="form-control">
                <option selected>Choose...</option>
                <option>...</option>
              </select>
            </div>
            <div class="form-group col-md-2">
              <label for="inputZip_permanent">Zip</label>
              <input type="text" name="inputZip_permanent" class="form-control" id="inputZip_permanent">
            </div>
          </div>
          <button type="submit" class="btn btn-primary">Save changes</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

        </form>
      </div>
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div> -->
    </div>
  </div>
</div>
<?php include '../../includes/footer.php'; ?>
<script>
  // Function to load users and pagination
  function loadUsers(page = 1) {
    $.ajax({
      url: '../../core/students.php', // Backend PHP script
      method: 'GET',
      data: {
        page: page
      },
      dataType: 'json',
      success: function(response) {
        // Display user data in the table
        var tableRows = '';
        $.each(response.users, function(index, user) {
          tableRows += `
                            <tr>
                                <td>${user.id}</td>
                                <td>${user.name}</td>
                                <td>${user.email}</td>
                                <td>${user.created_at}</td>
                            </tr>
                        `;
        });
        $('#usersTable tbody').html(tableRows);

        // Pagination controls
        var paginationButtons = '';

        // Add "Previous" button
        if (page > 1) {
          paginationButtons += `
                            <li class="page-item">
                                <a class="page-link" href="javascript:void(0);" onclick="loadUsers(${page - 1})">&laquo; Previous</a>
                            </li>
                        `;
        } else {
          paginationButtons += `
                            <li class="page-item disabled">
                                <a class="page-link" href="javascript:void(0);">&laquo; Previous</a>
                            </li>
                        `;
        }

        // Add page number buttons
        for (var i = 1; i <= response.total_pages; i++) {
          paginationButtons += `
                            <li class="page-item ${i === page ? 'active' : ''}">
                                <a class="page-link" href="javascript:void(0);" onclick="loadUsers(${i})">${i}</a>
                            </li>
                        `;
        }

        // Add "Next" button
        if (page < response.total_pages) {
          paginationButtons += `
                            <li class="page-item">
                                <a class="page-link" href="javascript:void(0);" onclick="loadUsers(${page + 1})">Next &raquo;</a>
                            </li>
                        `;
        } else {
          paginationButtons += `
                            <li class="page-item disabled">
                                <a class="page-link" href="javascript:void(0);">Next &raquo;</a>
                            </li>
                        `;
        }

        // Insert pagination buttons
        $('#paginationNav .pagination').html(paginationButtons);
      }
    });
  }

  loadUsers();

  $(document).ready(function () {

            $('#dataForm').on('submit', function (e) {
                e.preventDefault(); // Prevent default form submission
                const formData = new FormData(this);
                $.ajax({
                    url: '../../core/store.php', // PHP file to handle form submission
                    type: 'POST',
                    data: formData,
                    processData: false, // Prevent jQuery from converting FormData to a query string
                    contentType: false, // Use the default content type
                    success: function (response) {
                        // Parse JSON response

                        console.log(response);
                        
                        const data = response.data;

                        console.log(data);
                        if (data) {
                            // Append data to the table
                            const newRow = `<tr><td>${data.name}</td><td>${data.email}</td></tr>`;
                            $('#usersTable tbody').append(newRow);
                            $('#dataForm')[0].reset(); // Reset the form
                        } else {
                            alert(data.message); // Display error message
                        }
                    },
                    error: function (error) {
                       console.log(error);
                    }
                });
            });
        });


  //form validation
</script>