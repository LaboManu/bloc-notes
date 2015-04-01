<?php
	$isNew = false;
	$cmd = $_POST['cmd'];
	$id = $_POST['id'];
	$bnf = $_POST['bnf'];
	$download = $_GET['download'];
	$bnf_new=$_POST['bnf_new'];
	$cmdexec = $_POST['cmdexec'];
	$download = $_POST['download'];
	$rename = $_POST['rename'];
	$rename_to = $_POST['rename_to'];
	if($bnf=="")
	{
		$bnf = $_GET['bnf'];
	}
	$action = $_POST['action'];
	if($action=="")
	{
		$action = $_GET["action"];

	}
	if($action=="")

	{
		$action = "DEFAULT";
	}

	$content = $_POST['content'];
	
	if($id!="")
		$id++;
	else
		$id = 1;

	if($content=="" and $bnf=="")
	{
		$content = "Note " . $id;
	}
	
	if($bnf=="")
	{
		$bnf = "note " . rand() . ".TXT";
		$isNew = true;
	}


?>