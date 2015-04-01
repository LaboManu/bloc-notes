<?PHP
require_once("fg_membersite.php");

$fgmembersite = new FGMembersite();

//Provide your site name here
$fgmembersite->SetWebsiteName('manudahmen.be/blocnotes');

//Provide the email address where you want to get notifications
$fgmembersite->SetAdminEmail('manuel.dahmen@gmail.com');

//Provide your database login details here:
//hostname, user name, password, database name and table name
//note that the script will create the table (for example, fgusers in this case)
//by itself on submitting register.php for the first time
$fgmembersite->InitDB(/*hostname*/'manudahmen.be.mysql',
                      /*username*/'manudahmen_be',
                      /*password*/'Znduy32A',
                      /*database name*/'manudahmen_be',
                      /*table name*/'blocnotes_users');

//For better security. Get a random string from this link: http://tinyurl.com/randstr
// and put it here
$fgmembersite->SetRandomKey('VYqxPumA547MZIs');

?>