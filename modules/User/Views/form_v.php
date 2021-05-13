<?php echo view('header_v'); ?>
      <div class="page-content-wrapper">
        <div class="page-content-wrapper-inner">
          <div class="viewport-header">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb has-arrow">
                <li class="breadcrumb-item">
                  <a href="#">Users</a>
                </li>
                <?php $uri = service('uri'); ?>
                <li class="breadcrumb-item active" aria-current="page"><?php echo !empty($uri->getSegment(3))?'Edit':'New';?> User</li>
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
                      User Form
                    <p>
                   
                  </div>
                  <div class="grid-body">
                    <div class="item-wrapper">
                      <form method="POST" action="<?php echo base_url();?>/user/form<?php echo !empty($uri->getSegment(3))?"/".$uri->getSegment(3):'' ;?>">
                        <div class="row mb-3">
                          <div class="col-md-8 mx-auto">
                            <div class="form-group row showcase_row_area">
                              <div class="col-md-3 showcase_text_area">
                                <label for="username">User Name <span class="required">*</span></label>
                              </div>
                              <div class="col-md-9 showcase_content_area">
                                <input type="text" class="form-control <?php echo isset($errors['username'])?'is-invalid':'';?>" id="username" name="username" placeholder="Enter User Name" value="<?php echo isset($enterred['username'])?$enterred['username']:'';?>">
                                <div class="invalid-feedback"><?php echo isset($errors['username'])?$errors['username']:'';?></div>
                              </div>
                              
                            </div>

                            <div class="form-group row showcase_row_area">
                              <div class="col-md-3 showcase_text_area">
                                <label for="password">Password <span class="required">*</span></label>
                              </div>
                              <div class="col-md-9 showcase_content_area">
                                <input type="password" class="form-control <?php echo isset($errors['password'])?'is-invalid':'';?>" id="password" name="password" placeholder="Enter Password" value="<?php echo isset($enterred['password'])?$enterred['password']:'';?>">
                                <div class="invalid-feedback"><?php echo isset($errors['password'])?$errors['password']:'';?></div>
                              </div>
                            </div>
                            <hr>
                            <div class="form-group row showcase_row_area">
                              <div class="col-md-3 showcase_text_area">
                                <label for="firstname">First Name <span class="required">*</span></label>
                              </div>
                              <div class="col-md-9 showcase_content_area">
                                <input type="text" class="form-control <?php echo isset($errors['firstname'])?'is-invalid':'';?>" id="firstname" name="firstname" placeholder="Enter First Name" value="<?php echo isset($enterred['firstname'])?$enterred['firstname']:'';?>">
                                <div class="invalid-feedback"><?php echo isset($errors['firstname'])?$errors['firstname']:'';?></div>
                              </div>
                            </div>
                            <div class="form-group row showcase_row_area">
                              <div class="col-md-3 showcase_text_area">
                                <label for="lastname">Last Name <span class="required">*</span></label>
                              </div>
                              <div class="col-md-9 showcase_content_area">
                                <input type="text" class="form-control <?php echo isset($errors['lastname'])?'is-invalid':'';?>" id="lastname" name="lastname" placeholder="Enter Last Name" value="<?php echo isset($enterred['lastname'])?$enterred['lastname']:'';?>">
                                <div class="invalid-feedback"><?php echo isset($errors['lastname'])?$errors['lastname']:'';?></div>
                              </div>
                            </div>
                            <div class="form-group row showcase_row_area">
                              <div class="col-md-3 showcase_text_area">
                                <label for="email">Email</label>
                              </div>
                              <div class="col-md-9 showcase_content_area">
                                <input type="email" class="form-control <?php echo isset($errors['email'])?'is-invalid':'';?>" id="email" name="email" placeholder="Enter Email" value="<?php echo isset($enterred['email'])?$enterred['email']:'';?>">
                                <div class="invalid-feedback"><?php echo isset($errors['email'])?$errors['email']:'';?></div>
                              </div>
                            </div>
                            
                            <div class="form-group row showcase_row_area">
                              <div class="col-md-3 showcase_text_area">
                                <label for="contact_no">Contact Number</label>
                              </div>
                              <div class="col-md-9 showcase_content_area">
                                <input type="number" class="form-control <?php echo isset($errors['contact_no'])?'is-invalid':'';?>" id="contact_no" name="contact_no" minlength="10" placeholder="012XXXXXXX" value="<?php echo isset($enterred['contact_no'])?$enterred['contact_no']:'';?>">
                                <div class="invalid-feedback"><?php echo isset($errors['contact_no'])?$errors['contact_no']:'';?></div>
                              </div>
                            </div>
                            <div class="form-group row showcase_row_area">
                              <div class="col-md-3 showcase_text_area">
                                <label for="role">Role <span class="required">*</span></label>
                              </div>
                              <div class="col-md-9 showcase_content_area">
                              <select name="role" id="role" class="form-control <?php echo isset($errors['role'])?'is-invalid':'';?>">
                                <option value="">Select Role</option>
                                <?php 
                                
                                    if(!empty($roles)){

                                      foreach($roles as $role){

                                        ?>
                                        <option value="<?php echo $role->id;?>"  <?php  echo (isset($enterred['role']) && $enterred['role'] == $role->id)?'selected':'' ?>><?php echo $role->role_name;?></option>
                                        <?php
                                      }
                                    }
                                ?>
                              </select>
                              <div class="invalid-feedback"><?php echo isset($errors['role'])?$errors['role']:'';?></div>
                              </div>
                            </div>
                            
                          </div>
                        </div>
                        <button type="submit" class="btn btn-sm btn-primary"><?php echo !empty($uri->getSegment(3))?'Upate':'Create';?></button>
                        <a href="<?php echo base_url()?>/user/listing" class="btn btn-sm btn-secondary">Back</a>
                      </form>
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