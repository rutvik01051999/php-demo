<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
// $baseURL = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/php-project/views/admin';
include '../../core/functions.php';
session_start();
redirect_if_not_logged_in();
include '../../includes/header.php';
include '../../core/dropdown.php';

$states = getStates();
$search = $_GET['search'] ?? '';
$searchField = $_GET['searchField'] ?? 'name';
$sortOrder = $_GET['sortOrder'] ?? 'asc';
$sortField = $_GET['sortField'] ?? 'name';

?>
<div class="content-wrapper ">
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
            <form id="filterForm" method="GET" action="student.php">
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
                    <label class="form-check-label small" for="searchParent">Parents</label>
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
                <div class="col-4">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="sortField" id="sortName" value="name" <?= $sortField === 'name' ? 'checked' : '' ?>>
                    <label class="form-check-label small" for="sortName">Name</label>
                  </div>
                </div>
                <div class="col-4">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="sortField" id="sortEmail" value="email" <?= $sortField === 'email' ? 'checked' : '' ?>>
                    <label class="form-check-label small" for="sortEmail">Email</label>
                  </div>
                </div>
                <div class="col-4">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="sortField" id="sortDate" value="date" <?= $sortField === 'date' ? 'checked' : '' ?>>
                    <label class="form-check-label small" for="sortDate">Joing date</label>
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
          <th>Joining Date</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <!-- Data will be loaded dynamically here -->
      </tbody>
    </table>


  </div>

</div>
<!-- Modal -->

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Student</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="error"></div>
        <form id="dataForm">
          <input type="hidden" name="id" id="id">
          <div>Student Detail</div>
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
          <div>Current Address</div>
          <div class="form-group">
            <label for="inputAddress_current">Address</label>
            <input type="text" name="inputAddress_current" class="form-control" id="inputAddress_current" placeholder="1234 Main St">
          </div>
          <div class="form-group">
            <label for="inputAddress2_current">Address 2</label>
            <input type="text" name="inputAddress2_current" class="form-control" id="inputAddress2_current" placeholder="Apartment, studio, or floor">
          </div>
          <div class="form-row">

            <div class="form-group col-md-4">
              <label for="inputState_current">State</label>
              <select id="inputState_current" name="inputState_current" class="form-control">
                <option value="">Select State</option>
                <?php foreach ($states as $state): ?>
                  <option value="<?= htmlspecialchars($state['id']) ?>">
                    <?= htmlspecialchars($state['name']) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="form-group col-md-4">
              <label for="inputCity_current">City</label>
              <select id="inputCity_current" name="inputCity_current" class="form-control">

              </select>
            </div>


            <div class="form-group col-md-4">
              <label for="inputZip_current">Zip</label>
              <input type="text" name="inputZip_current" class="form-control" id="inputZip_current">
            </div>
          </div>

          <div>Permanent Address</div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" value="1" name="same_address" id="same_address">
            <label class="form-check-label" for="same_address">
              Same as current
            </label>
          </div>

          <div class="hide_section">
            <div class="form-group">
              <label for="inputAddress_permanent">Address</label>
              <input type="text" name="inputAddress_permanent" class="form-control" id="inputAddress_permanent" placeholder="1234 Main St">
            </div>
            <div class="form-group">
              <label for="inputAddress2_permanent">Address 2</label>
              <input type="text" name="inputAddress2_permanent" class="form-control" id="inputAddress2_permanent" placeholder="Apartment, studio, or floor">
            </div>
            <div class="form-row">

              <div class="form-group col-md-4">
                <label for="inputState_permanent">State</label>
                <select id="inputState_permanent" name="inputState_permanent" class="form-control">
                  <option value="">Select State</option>
                  <?php foreach ($states as $state): ?>
                    <option value="<?= htmlspecialchars($state['id']) ?>">
                      <?= htmlspecialchars($state['name']) ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>

              <div class="form-group col-md-4">
                <label for="inputCity_permanent">City</label>
                <select id="inputCity_permanent" name="inputCity_permanent" class="form-control">

                </select>
              </div>

              <div class="form-group col-md-4">
                <label for="inputZip_permanent">Zip</label>
                <input type="text" name="inputZip_permanent" class="form-control" id="inputZip_permanent">
              </div>
            </div>

          </div>
          <button type="submit" class="btn btn-primary">Save changes</button>
          <button type="button" class="btn btn-secondary close-footer" data-dismiss="modal">Close</button>

        </form>
      </div>
    </div>
  </div>
</div>
<?php include '../../includes/footer.php'; ?>
<script>
  function getQueryParam(param) {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.has(param) ? urlParams.get(param) : null;
  }
  // Function to load users and pagination
  function loadUsers(page = 1) {
    console.log('loaduser function page', page);
    $.ajax({
      url: '../../core/student/get.php',
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
              <td>${user.first_name}</td>
              <td>${user.email}</td>
              <td>${user.mobile}</td>
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

            console.log(i,page);

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


  loadUsers();

  $(document).ready(function() {
    $('#dataForm').on('submit', function(e) {
      let activePage = $('.active').find('.page-link').text();

      e.preventDefault(); // Prevent default form submission
      const formData = new FormData(this);
      // Handle checkbox
      if ($('#same_address').is(':checked')) {
        formData.append('same_address', 1); // Send 1 if checked
      } else {
        formData.append('same_address', 0); // Send 0 if unchecked
      }
      $.ajax({
        url: '../../core/student/store.php', // PHP file to handle form submission
        type: 'POST',
        data: formData,
        processData: false, // Prevent jQuery from converting FormData to a query string
        contentType: false, // Use the default content type
        success: function(response) {


          console.log(response.errors)
          // Parse JSON response

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
            loadUsers(parseInt(activePage)); // Reload users on the current page

          } else {
            // alert(data.message); // Display error message
          }
        },
        error: function(error) {
          console.log(error);
        }
      });
    });

    $('#same_address').on('change', function() {
      if ($(this).is(':checked')) {
        $('.hide_section').hide()
        $('#same_address').val(0);
      } else {
        $('.hide_section').show()
        $('#same_address').val(1);

      }

    });


    $('.addBtn').on('click', function() {
      $('#same_address').val(1);
      $('#same_address').prop('checked', false);
      $('.hide_section').show()
      $('#dataForm')[0].reset();
      $('#exampleModal').modal('show');
    });


    $(document).on('click', '.edit', function() {
      let userId = $(this).data('id');

      $.ajax({
        url: '../../core/student/edit.php', // PHP file to handle form submission
        type: 'POST',
        data: {
          "id": userId
        },
        dataType: 'json',
        success: function(response) {
          $('#exampleModal').modal('show');
          $('#first_name').val(response.data.first_name);
          $('#last_name').val(response.data.last_name);
          $('#inputEmail4').val(response.data.email);
          $('#mobile').val(response.data.mobile);
          $('#inputAddress_current').val(response.data.inputAddress_current);
          $('#inputAddress2_current').val(response.data.inputAddress2_current);
          $('#inputZip_current').val(response.data.inputZip_current);
          $('#inputCity_current').val(response.data.inputCity_current);
          $('#first_name').val(response.data.first_name);
          $('#id').val(response.data.id);
          $('#inputZip_permanent').val(response.data.inputZip_permanent);
          $('#inputState_current').val(response.data.inputState_current);
          if (response.data.same_address == 1) {
            console.log('same address checked');
            getCitiesCur(response.data.inputState_current, response.data.inputCity_current);
            $('#same_address').prop('checked', true);
            $('.hide_section').hide()
          } else {
            console.log('diff address');
            $('#same_address').prop('checked', false);
            $('.hide_section').show()
            getCitiesPer(response.data.inputState_permanent, response.data.inputCity_permanent);
            $('#inputAddress_permanent').val(response.data.inputAddress_permanent);
            $('#inputAddress2_permanent').val(response.data.inputAddress2_permanent);
            $('#inputCity_permanent').val(response.data.inputCity_permanent);
            $('#inputState_permanent').val(response.data.inputState_permanent);
          }

          console.log(response.data);
        },
        error: function(error) {
          console.log(error);
        }
      });
    });

    $(document).on('change', '#inputState_current', function() {
      var stateId = $(this).val();
      console.log(stateId, 'state id');
      getCitiesCur(stateId, 0);
      // if (stateId) {
      //   $.ajax({
      //     url: '../../core/student/get_cities.php',
      //     type: 'POST',
      //     data: {
      //       state_id: stateId
      //     },
      //     success: function(response) {
      //       $('#inputCity_current').html(response);
      //     }
      //   });
      // } else {
      //   $('#inputCity_current').html('<option value="">Select City</option>');
      // }
    });

    function getCitiesCur(stateId, $cityId) {
      if (stateId) {
        $.ajax({
          url: '../../core/student/get_cities.php',
          type: 'POST',
          data: {
            state_id: stateId
          },
          success: function(response) {
            $('#inputCity_current').html(response);
            if ($cityId) {
              $('#inputCity_current').val($cityId);
            }
          }
        });
      } else {
        $('#inputCity_current').html(response);
      }
    }

    function getCitiesPer(stateId, $cityId) {
      if (stateId) {
        $.ajax({
          url: '../../core/student/get_cities.php',
          type: 'POST',
          data: {
            state_id: stateId
          },
          success: function(response) {
            $('#inputCity_permanent').html(response);
            if ($cityId) {
              $('#inputCity_permanent').val($cityId);
            }
          }
        });
      } else {
        $('#inputCity_permanent').html(response);
      }
    }

    $(document).on('change', '#inputState_permanent', function() {
      var stateId = $(this).val();
      console.log(stateId, 'state id');
      getCitiesPer(stateId, 0);
      // if (stateId) {
      //   $.ajax({
      //     url: '../../core/student/get_cities.php',
      //     type: 'POST',
      //     data: {
      //       state_id: stateId
      //     },
      //     success: function(response) {
      //       $('#inputCity_permanent').html(response);
      //     }
      //   });
      // } else {
      //   $('#inputCity_permanent').html('<option value="">Select City</option>');
      // }
    });


    $(document).on('click', '.btn-delete', function() {
      let userId = $(this).data('id');
      Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: '../../core/student/delete.php', // PHP file to handle form submission
            type: 'POST',
            data: {
              "id": userId
            },
            dataType: 'json',
            success: function(response) {
              console.log(response.errors)

              if (response.success === false) {

              }
              if (response.success == true) {
                $('#exampleModal').modal('hide');
                loadUsers(parseInt($('.active').find('.page-link').text()));
              } else {
                // alert(data.message); // Display error message
              }
            },
            error: function(error) {
              console.log(error);
            }
          });
          Swal.fire({
            title: "Deleted!",
            text: "Your file has been deleted.",
            icon: "success"
          });
        }
      });
    });

  });
</script>