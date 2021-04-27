<?php echo view('header_v'); ?>
      <div class="page-content-wrapper">
        <div class="page-content-wrapper-inner">
          <div class="viewport-header">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb has-arrow">
                <li class="breadcrumb-item">
                  <a href="#">Users</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">User List</li>
              </ol>
            </nav>
          </div>
          <div class="content-viewport">
            <div class="row">
              <div class="col-lg-12">
                <div class="grid">
                  <?php echo get_msg();?>
                  <div class="grid-header">
                   
                    <p>
                      User List
                    <p>
                   
                  </div>
                  
                  <div class="item-wrapper">
                    <div class="row">
                      <div class="col-lg-12">
                        <div class="search-bar">
                        <form id="quick_search_form" action="<?php echo base_url();?>/user/search" method="POST">
                          <a href="#" class="search-label" data-toggle="modal" data-target="#search-modal">
                            Advance
                          </a>
                          <span  class="search-label divider">|</span>
                          <label class="search-label">Search:&nbsp;
                            <input type="text" name="search_name" class="form-control form-control-sm" placeholder="Name" value="<?php echo (isset($search_keys) && !empty($search_keys['search_name'])?$search_keys['search_name']:'');?>" >
                          </label>
                          </form>
                      </div>
                    </div>
                    </div>
                    <div class="table-responsive">
                      <table class="table info-table">
                        <thead>
                          <tr>
                            <th>No.</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Contact No.</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php if(!empty($results) && is_array($results)){ 

                                  $no = 1;

                                  foreach($results as $item){

                                    $status = '';

                                    if($item->status == 1){
                                      $status = "Active";
                                    }else{
                                      $status = "Disabled";
                                    }
                            ?>
                            <tr>
                              <td><?php echo $no; ?></td>
                              <td><?php echo !empty($item->firstname)?$item->firstname:EMPTY_FLAG; ?></td>
                              <td><?php echo !empty($item->lastname)?$item->lastname:EMPTY_FLAG; ?></td>
                              <td><?php echo !empty($item->email)?$item->email:EMPTY_FLAG; ?></td>
                              <td><?php echo !empty($item->contact_no)?$item->contact_no:EMPTY_FLAG; ?></td>
                              <td><?php echo !empty($item->role_name)?$item->role_name:EMPTY_FLAG; ?></td>
                              <td><?php echo !empty($status)?$status:EMPTY_FLAG; ?></td>
                              
                              <td class="actions">
                                <!-- <div class="btn-group">
                                  <a class="" href="#" id="actionDropdown" data-toggle="dropdown" aria-expanded="false">
                                    <i class="mdi mdi-dots-vertical mdi-1x"></i>
                                  </a>
                                  <div class="dropdown-menu" >
                                    <a class="dropdown-item" href="#">Privacy</a> 
                                    <a class="dropdown-item" href="#">Account</a> 
                                    <a class="dropdown-item" href="#">Data</a> 
                                    <a class="dropdown-item" href="#">Logout</a>
                                  </div>
                                  </div> -->

                                  <div class="dropdown">
                                    <a class="" href="#" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                      <i class="mdi mdi-dots-vertical mdi-1x"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
                                      <a class="dropdown-item" href="<?php echo base_url().'/user/form/'.wrap_data(array('user_id'=>$item->id));?>">Edit User</a>
                                    </div>
                                  </div>
                              </td>
                            </tr>
                          <?php 
                                $no++;
                                } 
                            }else{?>

                            <td colspan="8" class="text-center text-danger"> No Records </td>

                            <?php }?>
                        </tbody>
                      </table>
                    </div>
                    <div class="table-footer">
                      <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 ">
                          <?php echo '<span class="total-count">Total Records ' . $total_rows . '</span>'; ?>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 ">
                          <?php echo $pagination; ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              
            </div>
           
          </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="search-modal" tabindex="-1" role="dialog">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
            <form action="<?php echo base_url();?>/user/search" method="POST">
              <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">Advance Search</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                    <div class="item-wrapper">
                     
                        <div class="row">
                          <div class="col-md-12  mx-auto">
                            <div class="form-group">
                              <label for="search_name">Name</label>
                              <input type="text" class="form-control" name="search_name" id="search_name" placeholder="Enter name">
                            </div>
                            <div class="form-group">
                              <label for="search_email">Email</label>
                              <input type="email" class="form-control" name="search_email" id="search_email" placeholder="Enter email">
                            </div>
                            <div class="form-group">
                              <label for="search_role">Role</label>
                              <select name="search_role" id="search_role" class="form-control">
                                <option value="">Select Role</option>
                                <?php 
                                
                                    if(!empty($roles)){

                                      foreach($roles as $role){

                                        ?>
                                        <option value="<?php echo $role->id;?>"  <?php  echo (isset($search_keys['search_role']) && $search_keys['search_role'] == $role->id)?'selected':'' ?>><?php echo $role->role_name;?></option>
                                        <?php
                                      }
                                    }
                                ?>
                              </select>
                            </div>
                          </div>
                        </div>
                      
                    </div>
              </div>
              <div class="modal-footer">
                  <button type="submit" class="btn btn-primary">Search</button>
                  <a href="<?php echo base_url()?>/user/listing" class="btn btn-secondary" >Clear</a>
                </div>
              </div>
            </form>
          </div>
        </div>
        <script>
          $(function(){
            $('[name="search_name"]').keypress(function (e) {
              if (e.which == 13) {
                $('#quick_search_form').submit();
                return false;
              }
            });

          });
         
        </script>
        <!-- content viewport ends -->
        <?php echo view('footer_v'); ?>