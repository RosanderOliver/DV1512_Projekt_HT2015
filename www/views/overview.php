<?php

if (!defined("IN_EXM")) exit(1);

if ($login->isUserLoggedIn() === false) exit(1);

?>

<table cellpadding="10" cellspacing="0" border="0">

<!-- ============ LEFT COLUMN (COURSES) ============== -->
<td width="20%" valign="top">
<h2>Active Courses</h2>
<?php
  echo '<ul>';
  foreach ($user->getCourse() as $key => $value) {
    $course = $user->getCourse($value);
    echo '<li>';
    echo '<a href="?view=course&id='.$course->id.'">'.$course->name."</a>";
    echo '</li>';
  }
  echo '</ul>';
?>
</td>

<!-- ============ MIDDLE COLUMN (OVERVIEW) ============== -->
<td width="55%" valign="top" bgcolor="#FAFAFA">

<h2>Overview</h2>

<h3>Former BTH students among Sweden's best developers.</h3>
<p>Lorem ipsum dolor sit amet, esse molestie reformidans has id, has purto audire graecis ut.</p>
<h3>Multicultural environment at BTH</h1>
<p>Life on campus is multicultural as we attract students and staff from many countries in the world. In addition to the large number of nationalities</p>
<h3>European Network Intelligent Conference 2015</h3>
<p>The European Network Intelligent Conference, ENIC 2015 was recently held at BTH in collaboration with several international partner universities.</p>
<br>

</td>

<td width="25%" valign="top">

<h2>Tasks</h2>

<a href="?view=assignreviewers&id=1">Assign reviewers</a>

<br><br>

TASKTASKTATSK

<br><br>
TASKTASKTATSK

<br><br>

<?php
// Include the Shibboleth attributes you intend to test here
$attributes = array('displayName', 'mail', 'eppn', 'givenName', 'sn', 'affiliation', 'unscoped-affiliation');
foreach($attributes as $a){
    print "<p>";
    print "<strong>$a</strong> = ";
    print isset($_SERVER[$a]) ? $_SERVER[$a] : "<em>Undefined</em>";
    print "</p>";
}
?>

</tr>
</table>
