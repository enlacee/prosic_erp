<?php
$page = $_POST['page'];
$rp = $_POST['rp'];
$sortname = $_POST['sortname'];
$sortorder = $_POST['sortorder'];

if (!$sortname)
    $sortname = 'name';
if (!$sortorder)
    $sortorder = 'desc';

$sort = "ORDER BY $sortname $sortorder";

if (!$page)
    $page = 1;
if (!$rp)
    $rp = 10;

$start = (($page - 1) * $rp);

$limit = "LIMIT $start, $rp";

$query = $_POST['query'];
$qtype = $_POST['qtype'];

$where = "";

if ($query)
    $where = " WHERE $qtype LIKE '%$query%' ";
?>