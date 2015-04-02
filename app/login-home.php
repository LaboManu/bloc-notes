<?PHP
require_once("./include/membersite_config.php");

if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("login.php");
    exit;
}

require_once("page.xhtml.php");

?>
Welcome back <?= $fgmembersite->UserFullName(); ?>!

<p><a href='change-pwd.php'>Change password</a></p>

<p><a href='index.php'>Main page application</a></p>
<br><br><br>
<p><a href='logout.php'>Logout</a></p>
<!--
</div>
</body>
</html>
-->
