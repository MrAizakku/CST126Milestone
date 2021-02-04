<div>
<table>
<tr>
<th>ID</th><th>First Name</th><th>Last Name</th>
</tr>
<?php
    for($x=0; $x < count($results); $x++)
    {
 	  echo "<tr>";
 	  echo "<td>" . $results[$x][0] . "</td>" . "<td>" . $results[$x][1] . "</td>" . "</td>" . "<td>" . $results[$x][2] . "</td>";
 	  echo "</tr>";
 	}
 ?>
 </table>
 </div>