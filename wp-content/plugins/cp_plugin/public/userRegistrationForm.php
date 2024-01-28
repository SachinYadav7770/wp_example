<?php

$msg = '';

function userRegister($userData){
    global $wpdb;

    $result  = wp_insert_user($userData);
    if(!is_wp_error($result)){
        $response = 'user add and id : '.$result;
    }else {
        $response = $result->get_error_message();
    }

    return $response;
}

if(!empty($_POST['register-user'])){
    if(empty($_POST['password']) || $_POST['password'] != $_POST['c_password']){
        $msg = 'password error';
    }else{
        $user_data = [
            'user_login' => $_POST['username'] ?? '',
            'user_email' => $_POST['email'] ?? '',
            'first_name' => $_POST['first_name'] ?? '',
            'last_name' => $_POST['last_name'] ?? '',
            'display_name' => $_POST['first_name'].' '.$_POST['last_name'],
            'user_pass' => $_POST['password'] ?? ''
        ];
        $msg = userRegister($user_data);
    }
}

echo $msg;
?>

<form action="<?php echo get_the_permalink();?>" method="POST">
  <div class="form-group">
    <label for="firstName">First Name</label>
    <input type="text" class="form-control" id="firstName" placeholder="Enter First Name" name="first_name">
  </div>
  <div class="form-group">
    <label for="lastName">Last Name</label>
    <input type="text" class="form-control" id="lastName" placeholder="Enter Last Name" name="last_name">
  </div>
  <div class="form-group">
    <label for="userName">Username</label>
    <input type="text" class="form-control" id="userName" placeholder="Enter Username" name="username">
  </div>
  <div class="form-group">
    <label for="email">Email address</label>
    <input type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email" name="email">
  </div>
  <div class="form-group">
    <label for="password">Password</label>
    <input type="password" class="form-control" id="password" placeholder="Password" name="password">
  </div>
  <div class="form-group">
    <label for="c_password">Password</label>
    <input type="password" class="form-control" id="c_password" placeholder="Confirm password" name="c_password">
  </div>
  <!-- <div class="form-group form-check">
    <input type="checkbox" class="form-check-input" id="exampleCheck1">
    <label class="form-check-label" for="exampleCheck1">Check me out</label>
  </div> -->
  <!-- <button type="submit" class="btn btn-primary" >Submit</button> -->
  <input type="submit" value="Register" name="register-user">
</form>