<html>
<link href="css/stilmall.css" type="text/css" rel="stylesheet" />
<body>

<form action="#" method="get">
<table>

  <th>Student 1</th>
  <tr>
    <td>Full name: </td>
    <td colspan="6"><input type="text" name="student1"></td>
  </tr>
  <tr>
    <td>E-mail: </td>
    <td colspan="3"><input type="text" name="s1email"></td>
    <td >PNR: </td>
    <td colspan="2"><input type="text" name="pnr1"></td>
  </tr>

  <th>Student 2 (if applicable)</th>
  <tr>
    <td>Full name: </td>
    <td colspan="6"><input type="text" name="student2"></td>
  </tr>
  <tr>
    <td>E-mail: </td>
    <td colspan="3"><input type="text" name="s2email"></td>
    <td>PNR: </td>
    <td colspan="2"><input type="text" name="pnr2"></td>
  </tr>
  <th>Project information</th>
  <tr>
    <td>Title: </td>
    <td colspan="6"><input type="text" name="title"></td>
  </tr>
  <tr>
    <td>Supervisor: </td>
    <td colspan="6"><input type="text" name="supervisor"></td>
  <tr>
    <td>Supervisor: </td>
    <td colspan="6"><input type="text" name="supervisor"></td>
  </tr>
  <tr>
    <td>Thesis type:</td>
    <td colspan="3"><input type="text" name="thesistype" value="Master of Science, 30hp"></td>
  </tr>

  <th>Evaluation</th><th></th><th>Value (-,0-5)</th><th>AVG</th><th>TOT</th>
  <tr>
    <td><b>Process</b></td>
    <td>Independence, initiative and creativity</td>
    <td><select name="process1"><option>-</option><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select></td>
  </tr>
  <tr>
    <td>0.1</td>
    <td> Critical thinking and attitude</td>
    <td><select name="process2"><option>-</option><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select></td>
  </tr>
  <tr>
    <td></td>
    <td>Planning and execution</td>
    <td><select name="process3"><option>-</option><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select></td>
  </tr>
  <tr>
    <td></td>
    <td>Openness to critique and</td>
    <td><select name="process4"><option>-</option><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select></td>
    <td><i> - </i></td>
  </tr>
  <tr>
    <td></td><td></td>
  </tr>

  <tr>
    <td><b>Content</b></td>
    <td> Problem identification and formulation</td>
    <td><select name="content1"><option>-</option><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select></td>
  </tr>
  <tr>
    <td>0.4</td>
    <td> Evaluation</td>
    <td><select name="content2"><option>-</option><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select></td>
  </tr>
  <tr>
    <td></td>
    <td> Method selection and application</td>
    <td><select name="content3"><option>-</option><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select></td>
    <td><i> - </i></td>
  </tr>

  <tr>
    <td><b>Contribution</b></td>
    <td>Contribution to reasearch area (Master only)</td>
    <td><select name="contribution1"><option>-</option><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select></td>
  </tr>
  <tr>
    <td>0.25</td>
    <td>Contribution to reasearch/development (MSE only)</td>
    <td><select name="contribution2"><option>-</option><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select></td>
  </tr>
  <tr>
    <td></td>
    <td>Synthesis</td>
    <td><select name="contribution3"><option>-</option><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select></td>
    <td><i> - </i></td>
  </tr>

  <tr>
    <td><b>Presentation</b></td>
    <td> Disposition</td>
    <td><select name="presentation1"><option>-</option><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select></td>
  </tr>
  <tr>
    <td>0.25</td>
    <td> Adherence to formal rules and templates</td>
    <td><select name="presentation2"><option>-</option><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select></td>
  </tr>
  <tr>
    <td></td>
    <td> Description of work</td>
    <td><select name="presentation3"><option>-</option><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select></td>
  </tr>
  <tr>
    <td></td>
    <td> Analysis and argumentation</td>
    <td><select name="presentation4"><option>-</option><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select></td>
  <tr>
    <td></td>
    <td> Language</td>
    <td><select name="presentation5"><option>-</option><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select></td>
    <td><i> - </i></td>
    <td><i> - </i></td>
  </tr>

  <tr>
    <td><b>Computded grade</b></td><td></td><td></td><td></td><td> <i> - </i></td>
  </tr>
  <tr>
    <td><b>Overall impression</b></td><td></td><td></td><td></td><td><textarea name="name" rows="1"></textarea></td>
  </tr>

  <tr>
    <td>Reviewer</td>
    <td><input type="text" name="rname"></td>
    <td>Date</td>
    <td><input type="text" name="date" value="<?php echo date("d-m-Y"); ?>"></td>
  </tr>

  <th colspan="3">Comments and feedback</th>
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
