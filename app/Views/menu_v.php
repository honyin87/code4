<!-- partial:partials/_sidebar.html -->
<?php 
$session = session();
$user = null;
$role_desc = '';

if($session->has('user')){

  $user = $session->get('user');
  $roles = $session->get('roles');

  // Get primary role
  $role = $roles['roles'][0];

  foreach($roles['desc'] as $desc){

    if($desc->role_id == $role){
      $role_desc = $desc->role_name;
      break;
    }
  }
}
?>
<div class="sidebar">
        <div class="user-profile">
          <div class="display-avatar animated-avatar">
            <img class="profile-img img-lg rounded-circle" src="<?php echo base_url();?>/assets/images/profile/male/image_1.png" alt="profile image">
          </div>
          <div class="info-wrapper">
            <p class="user-name"><?php echo $user!==null?($user->firstname." ".$user->lastname):"New User"; ?></p>
            <h6 class="display-income"><?php echo $role_desc; ?></h6>
          </div>
        </div>
        <ul class="navigation-menu">
          <li class="nav-category-divider">MAIN</li>
          <li>
            <a href="index.html">
              <span class="link-title">Dashboard</span>
              <i class="mdi mdi-gauge link-icon"></i>
            </a>
          </li>
          <li>
            <a href="#user-pages" data-toggle="collapse" aria-expanded="false">
              <span class="link-title">Users</span>
              <i class="mdi mdi-account-supervisor link-icon"></i>
            </a>
            <ul class="collapse navigation-submenu" id="user-pages">
              <li>
                <a href="<?php echo base_url()."/user/listing"; ?>" >User List</a>
              </li>
              <li>
                <a href="<?php echo base_url()."/user/form"; ?>" >New User</a>
              </li>
            </ul>
          </li>
          <li>
            <a href="#sample-pages" data-toggle="collapse" aria-expanded="false">
              <span class="link-title">Sample Pages</span>
              <i class="mdi mdi-flask link-icon"></i>
            </a>
            <ul class="collapse navigation-submenu" id="sample-pages">
              <li>
                <a href="pages/sample-pages/login_1.html" >Login</a>
              </li>
              <li>
                <a href="pages/sample-pages/error_2.html" >Error</a>
              </li>
            </ul>
          </li>
          <li>
            <a href="#ui-elements" data-toggle="collapse" aria-expanded="false">
              <span class="link-title">UI Elements</span>
              <i class="mdi mdi-bullseye link-icon"></i>
            </a>
            <ul class="collapse navigation-submenu" id="ui-elements">
              <li>
                <a href="pages/ui-components/buttons.html">Buttons</a>
              </li>
              <li>
                <a href="pages/ui-components/tables.html">Tables</a>
              </li>
              <li>
                <a href="pages/ui-components/typography.html">Typography</a>
              </li>
            </ul>
          </li>
          <li>
            <a href="pages/forms/form-elements.html">
              <span class="link-title">Forms</span>
              <i class="mdi mdi-clipboard-outline link-icon"></i>
            </a>
          </li>
          <li>
            <a href="pages/charts/chartjs.html">
              <span class="link-title">Charts</span>
              <i class="mdi mdi-chart-donut link-icon"></i>
            </a>
          </li>
          <li>
            <a href="pages/icons/material-icons.html">
              <span class="link-title">Icons</span>
              <i class="mdi mdi-flower-tulip-outline link-icon"></i>
            </a>
          </li>
          <li class="nav-category-divider">ACCOUNT</li>
          <li>
            <a href="<?php echo base_url().'/auth/logout';?>">
              <span class="link-title">Logout</span>
              <i class="mdi mdi-logout link-icon"></i>
            </a>
          </li>
        </ul>
        <!-- <div class="sidebar-upgrade-banner">
          <p class="text-gray">Upgrade to <b class="text-primary">PRO</b> for more exciting features</p>
          <a class="btn upgrade-btn"  href="http://www.uxcandy.co/product/label-pro-admin-template/">Upgrade to PRO</a>
        </div> -->
      </div>
      <!-- partial -->