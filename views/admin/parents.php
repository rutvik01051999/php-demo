<?php
$baseURL = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/php-project/views/admin';
include '../../core/functions.php';
session_start();
redirect_if_not_logged_in();
include '../../includes/header.php';
include '../../core/dropdown.php';
$students = getStudents();


$search = $_GET['search'] ?? '';
$searchField = $_GET['searchField'] ?? 'name';
$sortOrder = $_GET['sortOrder'] ?? 'asc';
$sortField = $_GET['sortField'] ?? 'name';

// print_r($students);
// exit;

?>

<div class="content-wrapper">
  <div class="container mt-5">
    <div class="row g-2 align-items-center">
      <div class="col-auto">
        <button type="button" class="btn btn-primary addBtn">Add</button>
      </div>
      <div class="col-auto">
        <div class="dropdown">
          <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            Filter
          </button>

          <div class="dropdown-menu p-3" style="min-width: 320px;">
            <form id="filterForm" method="GET" action="parents.php">
              <!-- Search box -->
              <div class="row mb-2">
                <div class="col-12">
                  <input type="text" class="form-control form-control-sm" name="search" placeholder="Search..." value="<?= htmlspecialchars($search) ?>">
                </div>
              </div>

              <!-- Search In -->
              <div class="row mb-2">
                <div class="col-12"><strong class="small">Search In</strong></div>
                <div class="col-4">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="searchField" id="searchName" value="name" <?= $searchField === 'name' ? 'checked' : '' ?>>
                    <label class="form-check-label small" for="searchName">Name</label>
                  </div>
                </div>
                <div class="col-4">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="searchField" id="searchEmail" value="email" <?= $searchField === 'email' ? 'checked' : '' ?>>
                    <label class="form-check-label small" for="searchEmail">Email</label>
                  </div>
                </div>
                <div class="col-4">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="searchField" id="searchParent" value="parents_name" <?= $searchField === 'parents_name' ? 'checked' : '' ?>>
                    <label class="form-check-label small" for="searchParent">Mobile</label>
                  </div>
                </div>
              </div>

              <!-- Sort Order -->
              <div class="row mb-2">
                <div class="col-12"><strong class="small">Sort Order</strong></div>
                <div class="col-6">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="sortOrder" id="asc" value="asc" <?= $sortOrder === 'asc' ? 'checked' : '' ?>>
                    <label class="form-check-label small" for="asc">ASC</label>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="sortOrder" id="desc" value="desc" <?= $sortOrder === 'desc' ? 'checked' : '' ?>>
                    <label class="form-check-label small" for="desc">DESC</label>
                  </div>
                </div>
              </div>

              <!-- Sort By -->
              <div class="row mb-2">
                <div class="col-12"><strong class="small">Sort By</strong></div>
                <div class="col-6">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="sortField" id="sortName" value="name" <?= $sortField === 'name' ? 'checked' : '' ?>>
                    <label class="form-check-label small" for="sortName">Name</label>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="sortField" id="sortEmail" value="email" <?= $sortField === 'email' ? 'checked' : '' ?>>
                    <label class="form-check-label small" for="sortEmail">Email</label>
                  </div>
                </div>

              </div>

              <!-- Submit -->
              <div class="row">
                <div class="col-6">
                  <button type="submit" class="btn btn-sm btn-primary w-100">Apply Filter</button>
                </div>
                <div class="col-6">
                  <button type="button" class="btn btn-sm btn-success w-100">Clear Filter</button>
                </div>
              </div>
            </form>

          </div>
        </div>

      </div>
    </div>
    <br>

    <!-- Pagination controls -->
    <nav id="paginationNav">
      <ul class="pagination">
        <!-- Pagination buttons will be inserted here -->
      </ul>
    </nav>

    <!-- Table to display user data -->
    <table class="table table-bordered" id="usersTable">
      <thead>
        <tr>
          <th></th>
          <th>Name</th>
          <th>Email</th>
          <th>Mobile</th>
          <th>Students</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <!-- Data will be loaded dynamically here -->
      </tbody>
    </table>


  </div>
  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="dataForm">
            <input type="hidden" name="id" id="id">
            <div>Parants Detail</div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="first_name">First Name</label>
                <input type="text" class="form-control" name="first_name" id="first_name" placeholder="first_name">
              </div>
              <div class="form-group col-md-6">
                <label for="last_name">Last Name</label>
                <input type="text" name="last_name" class="form-control" id="last_name" placeholder="last_name">
              </div>
            </div>
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
            <div>Students detail</div>

            <div class="col-12 col-sm-6">
              <div class="form-group">
                <div class="select2-purple">
                  <select class="select2" name="students[]" multiple="multiple" data-placeholder="Select a State" data-dropdown-css-class="select2-purple" style="width: 100%;">
                    <option>Alabama</option>
                    <?php foreach ($students as $key => $student): ?>
                      <option value="<?= htmlspecialchars($student['student_id']) ?>">
                        <?= htmlspecialchars($student['first_name'] . ' - ' . $student['name'] . ' - ' . $student['div_name']) ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <!-- /.form-group -->
            </div>
            <!-- /.col -->
            <button type="button" class="btn btn-secondary close-footer" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
          </form>
        </div>
      </div>
    </div>
  </div>

</div>
<?php include '../../includes/footer.php'; ?>

<script>
  $(document).ready(function() {
    function getQueryParam(param) {
      const urlParams = new URLSearchParams(window.location.search);
      return urlParams.has(param) ? urlParams.get(param) : null;
    }
    loadUsers();
    $('.addBtn').on('click', function() {
      $('#same_address').val(1);
      $('#same_address').prop('checked', false);
      //  $('.hide_section').show()
      //$('#dataForm')[0].reset();
      $('#exampleModal').modal('show');
    });

    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

    function loadUsers(page = 1) {
      console.log('loaduser function page', page);
      $.ajax({
        url: '../../core/parents/get.php',
        method: 'GET',
        data: {
          page: page,
          search: getQueryParam('search'),
          searchField: getQueryParam('searchField'),
          sortOrder: getQueryParam('sortOrder'),
          sortField: getQueryParam('sortField'),
        },
        dataType: 'json',
        success: function(response) {

          // Display user data
          var tableRows = '';
          $.each(response.users, function(index, user) {
            tableRows += `
          <tr class="user-row">
              <td>${index+1}</td>
              <td>${user.student_first_name}</td>
              <td>${user.email}</td>
              <td>${user.mobile}</td>
              <td>${user.parent_names || '-'}</td>
              <td>${user.created_at}</td>
              <td>
                  <button class="btn btn-primary btn-sm edit" data-id="${user.id}">
                      <i class="fas fa-edit"></i> Edit
                  </button>
                  <button class="btn btn-danger btn-sm btn-delete" data-id="${user.id}">
                      <i class="fas fa-trash-alt"></i> Delete
                  </button>
              </td>
          </tr>
        `;
          });
          $('#usersTable tbody').html('');
          $('#usersTable tbody').html(tableRows);

          // Build pagination
          const totalPages = response.total_pages;
          let paginationButtons = '';

          // Previous button
          paginationButtons += `
        <li class="page-item ${page <= 1 ? 'disabled' : ''}">
          <a class="page-link" href="javascript:void(0);" onclick="${page > 1 ? `loadUsers(${page - 1})` : ''}">&laquo; Prev</a>
        </li>
      `;

          let delta = 2; // Number of pages around current
          let range = [];
          let rangeWithDots = [];
          let l;

          for (let i = 1; i <= totalPages; i++) {
            if (i === 1 || i === totalPages || (i >= page - delta && i <= page + delta)) {
              range.push(i);
            }
          }

          for (let i of range) {
            if (l) {
              if (i - l === 2) {
                rangeWithDots.push(l + 1);
              } else if (i - l > 2) {
                rangeWithDots.push('...');
              }
            }
            rangeWithDots.push(i);
            l = i;
          }

          for (let i of rangeWithDots) {
            if (i === '...') {
              paginationButtons += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
            } else {

              console.log(i, page);

              paginationButtons += `
            <li class="page-item ${i === page ? 'active' : ''}">
              <a class="page-link" href="javascript:void(0);" onclick="loadUsers(${i})">${i}</a>
            </li>
          `;
            }
          }

          // Next button
          paginationButtons += `
        <li class="page-item ${page >= totalPages ? 'disabled' : ''}">
          <a class="page-link" href="javascript:void(0);" onclick="${page < totalPages ? `loadUsers(${page + 1})` : ''}">Next &raquo;</a>
        </li>
      `;

          $('#paginationNav .pagination').html(paginationButtons);

        }
      });
    }

    $('#dataForm').on('submit', function(e) {
      console.log('Form submitted');
      let activePage = $('.active').find('.page-link').text();

      e.preventDefault(); // Prevent default form submission
      const formData = new FormData(this);
      $.ajax({
        url: '../../core/parent/store.php', // PHP file to handle form submission
        type: 'POST',
        data: formData,
        processData: false, // Prevent jQuery from converting FormData to a query string
        contentType: false, // Use the default content type
        success: function(response) {


          console.log(response.errors)
          if (response.success === false) {
            console.log(response.errors); // Debugging: Check the type of response.errors

            if (Array.isArray(response.errors)) {
              response.errors.forEach(function(error) {
                toastr.error(error);
              });
            } else if (typeof response.errors === 'string') {
              toastr.error(response.errors); // Handle the case where errors is a single string
            } else if (typeof response.errors === 'object') {
              // If it's an object, extract its values
              Object.values(response.errors).forEach(function(error) {
                toastr.error(error);
              });
            } else {
              toastr.error("An unknown error occurred.");
            }
          }


          if (response.success == true) {

            $('#exampleModal').modal('hide');
            $('#dataForm')[0].reset();
            // loadUsers(parseInt(activePage)); // Reload users on the current page

          } else {
            console.log(response.message); // Display error message
          }
        },
        error: function(error) {
          console.log(error);
        }
      });
    });
  });
</script>