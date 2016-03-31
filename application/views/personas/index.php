<?php
    use plugin\form\Form;
    use plugin\cryptography\Cryptography;
    use plugin\auth\Auth;
    use plugin\db\DB;
    use plugin\katana\Katana;
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
    
    Auth::attempt();

/*
    $sole = "Angelo";
    $sole = Cryptography::encode($sole);
    echo $sole . "<br>";
    $sole = Cryptography::decode($sole);
    echo $sole . "<br>";
    
    
    Form::open(['method' => 'get', 'url' => '']);
    Form::label('ciao', 'Label per Ciao');
    Form::text('ciao','scrivi ciao');
    
    //Form::password('ciao2','scrivi ciao');
    //Form::number('ciao3',17);
    //Form::email('ciao4','scrivi ciao');
    
    Form::submit();
    Form::close();
    
    //$prova=DB::open("utenti")->get();
    //var_dump2($prova);

var_dump2(token_get_all('<?php echo $ciao; ?>'));
var_dump2(token_name(376));
var_dump2(token_name(319));
var_dump2(token_name(379));
var_dump2(token_name(312));
var_dump2(token_name(379));
var_dump2(token_name(378));



echo compileRawEchos("
    asd
    @{!! pippo baudo capellone !!}
    blabla
    asd
");

echo "<br />";
echo "<br />";

echo compileEchoDefaults('$asd or ciao');

function compileEchoDefaults($value)
    {
        return preg_replace('/^(?=\$)(.+?)(?:\s+or\s+)(.+?)$/s', 'isset($1) ? $1 : $2', $value);
    }

function compileRawEchos($value)
    {
        $pattern = sprintf('/(@)?%s\s*(.+?)\s*%s(\r?\n)?/s', "{!!", "!!}");

        $callback = function ($matches) {
            $whitespace = empty($matches[3]) ? '' : $matches[3].$matches[3];
            var_dump2($matches);
            return $matches[1] ? substr($matches[0], 1) : 'ciao'.$whitespace;
            //' echo '.$this->compileEchoDefaults($matches[2]).';'.;
        };

        return preg_replace_callback($pattern, $callback, $value);
    }


echo "<br />";
echo "<br />";

    //Katana::convert();


*/