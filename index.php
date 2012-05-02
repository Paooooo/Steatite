<?php
/*
STEATITE - Pictures archive for qualitative analysis

Copyright (C) 2012 Aurelien Benel

OFFICIAL WEB SITE
http://www.hypertopic.org/

LEGAL ISSUES
This program is free software; you can redistribute it and/or modify it under
the terms of the GNU Affero General Public License as published by the Free 
Software Foundation.
This program is distributed in the hope that it will be useful, but WITHOUT ANY
WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A
PARTICULAR PURPOSE. See the GNU Affero General Public License for more details:
http://www.gnu.org/licenses/agpl.html
*/

include('lib/Mustache.php');

$db = new PDO('sqlite:attribute/database');
$count = 
  $db->query("SELECT count(distinct source_id) FROM attributes")->fetch();
$data = array(
  'count' => $count[0]
);
$result = $db->query(
  "SELECT attribute_value, count(1) FROM attributes "
  ."WHERE attribute_name='corpus' GROUP BY attribute_value"
);
foreach ($result as $row) {
  $data['corpora'][] = array(
    'id' => $row[0],
    'count' => $row[1]
  );
}
$renderer = new Mustache();
echo $renderer->render(file_get_contents('./template/index.html'), $data);

?>