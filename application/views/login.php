<?php
    use plugin\auth\Auth;
    
    echo "asd";
    //var_dump(Auth::attempt());
    var_dump2($_POST);
    var_dump2($controllerName);

    var_dump2(Auth::attempt(['username' => $_POST['username'], 'password' => $_POST['password']]));