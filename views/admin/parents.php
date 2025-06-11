<?php
$baseURL = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/php-project/views/admin';
include '../../core/functions.php';
session_start();
redirect_if_not_logged_in();
include '../../includes/header.php';
?>
<div class="content-wrapper ">
  <div class="container mt-5"><br>
    <button type="button" class="btn btn-primary addBtn">
      Add
    </button>

    <!-- Filter Button -->
    <button type="button" class="btn btn-primary" id="filterBtn">Filter</button><br><br>

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
          <th>Date</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <!-- Data will be loaded dynamically here -->
      </tbody>
    </table>


  </div>

</div>
<div class="content-wrapper container">
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
            <div class="form-group col-md-6">
              <label for="inputCity_current">City</label>
              <input type="text" name="inputCity_current" class="form-control" id="inputCity_current">
            </div>
            <div class="form-group col-md-4">
              <label for="inputState_current">State</label>
              <select id="inputState_current" name="inputState_current" class="form-control">
                <option selected>Choose...</option>
                <option>Gujarat</option>
                <option>Maharashtra</option>

              </select>
            </div>
            <div class="form-group col-md-2">
              <label for="inputZip_current">Zip</label>
              <input type="text" name="inputZip_current" class="form-control" id="inputZip_current">
            </div>
          </div>

        </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close-footer" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>

</div>
<?php include '../../includes/footer.php'; ?>
<script>
  
  $('.addBtn').on('click', function() {
      $('#same_address').val(1);
      $('#same_address').prop('checked', false);
    //  $('.hide_section').show()
      //$('#dataForm')[0].reset();
      $('#exampleModal').modal('show');
    });  
</script>
  
