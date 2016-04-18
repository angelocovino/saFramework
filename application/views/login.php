<?php
    use plugin\auth\Auth;
    use library\request\Request;
    use plugin\session\Session;
    
    //var_dump(Auth::attempt());
    //var_dump2($_POST);
    //var_dump2($controllerName);

    //var_dump2(Auth::attempt(['username' => $_POST['username'], 'password' => $_POST['password']]));
    //var_dump2(Request::getParameters());
    //Auth::check();
    Auth::login();
    var_dump2(Auth::check());
    var_dump2($_SESSION);