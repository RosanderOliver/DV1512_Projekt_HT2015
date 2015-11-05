<html>
<link href="css/stilmall.css" type="text/css" rel="stylesheet" />
<body>

<form action="#" method="get">
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
    <td><select name="process1"><option>-</option><option>0</option><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select></td>
    <td>Independence, initiative and creativity</td>
    <td colspan="3"><textarea type="text" name="processcomment1" rows="2"></textarea></td>
  </tr>
  <tr>
    <td></td>
    <td><select name="process2"><option>-</option><option>0</option><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select></td>
    <td> Critical thinking and attitude</td>
    <td colspan="3"><textarea type="text" name="processcomment2" rows="2"></textarea></td>
  </tr>
  <tr>
    <td></td>
    <td><select name="process3"><option>-</option><option>0</option><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select></td>
    <td> Openness to critique and supervision</td>
    <td colspan="3"><textarea type="text" name="processcomment3" rows="2"></textarea></td>
  </tr>
  <tr>
    <td></td><td>-</td>
  </tr>

  <tr>
    <td><b>Content:</b></td>
    <td><select name="content1"><option>-</option><option>0</option><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select></td>
    <td> Problem identification and formulation</td>
    <td colspan="3"><textarea type="text" name="contentcomment1" rows="2"></textarea></td>
  </tr>
  <tr>
    <td></td>
    <td><select name="content2"><option>-</option><option>0</option><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select></td>
    <td> Evaluation</td>
    <td colspan="3"><textarea type="text" name="contentcomment2" rows="2"></textarea></td>
  </tr>
  <tr>
    <td></td>
    <td><select name="content3"><option>-</option><option>0</option><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select></td>
    <td> Method selection and application</td>
    <td colspan="3"><textarea type="text" name="contentcomment2" rows="2"></textarea></td>
  </tr>
  <tr>
    <td></td>
    <td><select name="content4"><option>-</option><option>0</option><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select></td>
    <td> Planning</td>
    <td colspan="3"><textarea type="text" name="contentcomment4" rows="2"></textarea></td>
  </tr>
  <tr>
    <td></td><td>-</td>
  </tr>

  <tr>
    <td><b>Presentation:</b></td>
    <td><select name="presentation1"><option>-</option><option>0</option><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select></td>
    <td> Disposition</td>
    <td colspan="3"><textarea type="text" name="presentationcomment1" rows="2"></textarea></td>
  </tr>
  <tr>
    <td></td>
    <td><select name="presentation2"><option>-</option><option>0</option><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select></td>
    <td> Adherence to formal rules and templates</td>
    <td colspan="3"><textarea type="text" name="presentationcomment2" rows="2"></textarea></td>
  </tr>
  <tr>
    <td></td>
    <td><select name="presentation3"><option>-</option><option>0</option><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select></td>
    <td> Description of work</td>
    <td colspan="3"><textarea type="text" name="presentationcomment3" rows="2"></textarea></td>
  </tr>
  <tr>
    <td></td>
    <td><select name="presentation4"><option>-</option><option>0</option><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select></td>
    <td> Analysis and argumentation</td>
    <td colspan="3"><textarea type="text" name="presentationcomment4" rows="2"></textarea></td>
  </tr>
  <tr>
    <td></td>
    <td><select name="presentation5"><option>-</option><option>0</option><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select></td>
    <td> Language</td>
    <td colspan="3"><textarea type="text" name="presentationcomment5" rows="2"></textarea></td>
  </tr>
  <tr>
    <td></td><td>-</td>
  </tr>

  <tr>
    <td><b>Grade:</b></td><td> <i>(display grade)</i></td>
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
