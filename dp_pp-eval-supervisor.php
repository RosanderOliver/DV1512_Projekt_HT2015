<html>
<link href="css/stilmall.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="javascript/form.js"></script>
<body>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="get" name="pp">
<table>

  <th>Student 1</th>
  <tr>
    <td>Full name</td>
    <td colspan="6"><input type="text" name="student1"></td>
  </tr>
  <tr>
    <td>E-mail</td>
    <td colspan="3"><input type="text" name="s1email"></td>
    <td >Social sec nr: </td>
    <td colspan="2"><input type="text" name="s1socialsecnr"></td>
  </tr>

  <th>Student 2 (if applicable)</th>
  <tr>
    <td>Full name</td>
    <td colspan="6"><input type="text" name="student2"></td>
  </tr>
  <tr>
    <td>E-mail</td>
    <td colspan="3"><input type="text" name="s2email"></td>
    <td>Social sec nr: </td>
    <td colspan="2"><input type="text" name="s2socialsecnr"></td>
  </tr>
  <th>Project information</th>
  <tr>
    <td>Title </td>
    <td colspan="6"><input type="text" name="title"></td>
  </tr>
  <tr>
    <td>Course</td>
    <td colspan="6"><input type="text" name="course"></td>
  </tr>
  <tr>
    <td>Supervisor</td>
    <td><input type="text" name="supervisor"></td>
    <td>Term (e.g. vt14): </td>
    <td><input type="text" name="term"></td>
    <td>Type:</td>
    <td><input type="number" name"type" min="1" max="4"></td>
    <td rowspan="3">
      <ol>
        <li>Bacelor of Science</li>
        <li>Master of Science (1-year)</li>
        <li>Master of Science (2-year)</li>
        <li>Master of Science in Engineering ("civilingenj&ouml;r")</li>
      </ol>
    </td>
  </tr>
  <th>Evaluation</th><th>Value (-,0-5)</th><th>Specific short comments</th>
  <tr>
    <td><b>Process</b></td>
    <td><select name="process1" onchange="check(pp.process1.value, pp.process2.value, pp.process3.value)"><option>-</option><option>0</option><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select></td>
    <td>Independence, initiative and creativity</td>
    <td colspan="3"><textarea type="text" name="processcomment1" rows="2"></textarea></td>
  </tr>
  <tr>
    <td></td>
    <td><select name="process2" onchange="check(pp.process1.value, pp.process2.value, pp.process3.value)"><option>-</option><option>0</option><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select></td>
    <td> Critical thinking and attitude</td>
    <td colspan="3"><textarea type="text" name="processcomment2" rows="2"></textarea></td>
  </tr>
  <tr>
    <td></td>
    <td><select name="process3" onchange="check(pp.process1.value, pp.process2.value, pp.process3.value)"><option>-</option><option>0</option><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select></td>
    <td> Openness to critique and supervision</td>
    <td colspan="3"><textarea type="text" name="processcomment3" rows="2"></textarea></td>
  </tr>
  <tr>
    <td></td><td><input type="text" name="s1" id="s1" value=""></td><td></td>
  </tr>

  <tr>
    <td><b>Content</b></td>
    <td><select name="content1" onchange="check(pp.content1.value, pp.content2.value, pp.content3.value, pp.content4.value)"><option>-</option><option>0</option><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select></td>
    <td> Problem identification and formulation</td>
    <td colspan="3"><textarea type="text" name="contentcomment1" rows="2"></textarea></td>
  </tr>
  <tr>
    <td></td>
    <td><select name="content2" onchange="check(pp.content1.value, pp.content2.value, pp.content3.value, pp.content4.value)"><option>-</option><option>0</option><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select></td>
    <td> Evaluation</td>
    <td colspan="3"><textarea type="text" name="contentcomment2" rows="2"></textarea></td>
  </tr>
  <tr>
    <td></td>
    <td><select name="content3" onchange="check(pp.content1.value, pp.content2.value, pp.content3.value, pp.content4.value)"><option>-</option><option>0</option><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select></td>
    <td> Method selection and application</td>
    <td colspan="3"><textarea type="text" name="contentcomment2" rows="2"></textarea></td>
  </tr>
  <tr>
    <td></td>
    <td><select name="content4" onchange="check(pp.content1.value, pp.content2.value, pp.content3.value, pp.content4.value)"><option>-</option><option>0</option><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select></td>
    <td> Planning</td>
    <td colspan="3"><textarea type="text" name="contentcomment4" rows="2"></textarea></td>
  </tr>
  <tr>
    <td></td><td><input type="text" name="s2" id="s2" value=""></td><td></td>
  </tr>

  <tr>
    <td><b>Presentation</b></td>
    <td><select name="presentation1" onchange="check(pp.presentation1.value, pp.presentation2.value, pp.presentation3.value, pp.presentation4.value, pp.presentation5.value)"><option>-</option><option>0</option><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select></td>
    <td> Disposition</td>
    <td colspan="3"><textarea type="text" name="presentationcomment1" rows="2"></textarea></td>
  </tr>
  <tr>
    <td></td>
    <td><select name="presentation2" onchange="check(pp.presentation1.value, pp.presentation2.value, pp.presentation3.value, pp.presentation4.value, pp.presentation5.value)"><option>-</option><option>0</option><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select></td>
    <td> Adherence to formal rules and templates</td>
    <td colspan="3"><textarea type="text" name="presentationcomment2" rows="2"></textarea></td>
  </tr>
  <tr>
    <td></td>
    <td><select name="presentation3" onchange="check(pp.presentation1.value, pp.presentation2.value, pp.presentation3.value, pp.presentation4.value, pp.presentation5.value)"><option>-</option><option>0</option><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select></td>
    <td> Description of work</td>
    <td colspan="3"><textarea type="text" name="presentationcomment3" rows="2"></textarea></td>
  </tr>
  <tr>
    <td></td>
    <td><select name="presentation4" onchange="check(pp.presentation1.value, pp.presentation2.value, pp.presentation3.value, pp.presentation4.value, pp.presentation5.value)"><option>-</option><option>0</option><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select></td>
    <td> Analysis and argumentation</td>
    <td colspan="3"><textarea type="text" name="presentationcomment4" rows="2"></textarea></td>
  </tr>
  <tr>
    <td></td>
    <td><select name="presentation5" onchange="check(pp.presentation1.value, pp.presentation2.value, pp.presentation3.value, pp.presentation4.value, pp.presentation5.value)"><option>-</option><option>0</option><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select></td>
    <td> Language</td>
    <td colspan="3"><textarea type="text" name="presentationcomment5" rows="2"></textarea></td>
  </tr>
  <tr>
    <td></td><td><input type="text" name="s3" id="s3" value=""></td><td></td>
  </tr>

  <tr>
    <td><b>Grade:</b></td><td><input type="text" name="s4" id="s4" value="" onclick="pass(pp.s1.value, pp.s2.value, pp.s3.value)"></td><td>(<-- click to refresh)</td>
  </tr>

  <th colspan="3">Overall comments and feedback</th>
  <tr>
    <td colspan="7"><textarea name="feedback" rows="20"></textarea></td>
  </tr>

  <tr>
    <td><input type="button" name="name" value="Submit evaluation"></td>
  </tr>


</table>
</form>


</body>
</html>
