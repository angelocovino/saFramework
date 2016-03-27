<?php
    use plugin\form\Form;
    use plugin\cryptography\Cryptography;
    use plugin\auth\Auth;
?>
<span style="display:block; border:1px solid black;">
    <h2>persona's index</h2>
    <form method="post" action="">
        <input type="text" name="username" value="angelotm" placeholder="username" />
        <input type="text" name="password" value="napoli" placeholder="password" />
        <input type="hidden" name="action" value="login" />
        <input type="submit" value="Login" />
    </form>
    <form method="post" action="">
        <input type="hidden" name="action" value="logout" />
        <input type="submit" value="Logout" />
    </form>
</span>

<?php
    $sole = "Angelo";
    $sole = Cryptography::encode($sole);
    echo $sole . "<br>";
    $sole = Cryptography::decode($sole);
    echo $sole . "<br>";
    

    Form::open(['method' => 'get', 'url' => '']);
    Form::label('ciao', 'Label per Ciao');
    Form::text('ciao','scrivi ciao');
    /*
    Form::password('ciao2','scrivi ciao');
    Form::number('ciao3',17);
    Form::email('ciao4','scrivi ciao');
    */
    Form::submit();
    Form::close();


    //var_dump2($_SERVER);


    $a = new Auth();