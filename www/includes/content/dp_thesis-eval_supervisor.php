

<form action="index.php?view=reviewthesis&sid=<?php echo $submissionsId?>" method="post" name="thesis"  onmouseover="tot(thesis.s1.value, thesis.s2.value, thesis.s3.value, thesis.s4.value)">
<table class="form_table">

  <th>Student 1</th>
  <tr>
    <td>Full name: </td>
    <td colspan="6"><input type="text" name="student1" class="form_input" maxlength="128" value="<?php if($data != null){echo $data->student1;} ?>" required></td> <!-- required -->
  </tr>
  <tr>
    <td>E-mail: </td>
    <td colspan="2"><input type="text" name="s1email" class="form_input" maxlength="128" value="<?php if($data != null){echo $data->s1email;} ?>" required></td> <!-- required -->
    <td >PNR:</td>
    <td colspan="2"><input type="text" name="pnr1" class="form_input" maxlength="20" value="<?php if($data != null){echo $data->pnr1;} ?>" required></td> <!-- required -->
  </tr>

  <th>Student 2 (if applicable)</th>
  <tr>
    <td>Full name: </td>
    <td colspan="6"><input type="text" name="student2" maxlength="128" value="<?php if($data != null){echo $data->student2;} ?>" class="form_input"></td>
  </tr>
  <tr>
    <td>E-mail:</td>
    <td colspan="2"><input type="text" name="s2email" maxlength="128" class="form_input" value="<?php if($data != null){echo $data->s2email;} ?>"></td>
    <td >PNR: </td>
    <td colspan="2"><input type="text" name="pnr2" maxlength="20" class="form_input" value="<?php if($data != null){echo $data->pnr2;} ?>"></td>
  </tr>
  <th>Project information</th>
  <tr>
    <td>Title: </td>
    <td colspan="6"><input type="text" name="title" class="form_input" maxlength="128" value="<?php if($data != null){echo $data->title;} ?>" required></td> <!-- required -->
  </tr>
  <tr>
    <td>Supervisor: </td>
    <td colspan="6"><input type="text" name="supervisor" class="form_input" maxlength="128" value="<?php if($data != null){echo $data->supervisor;} ?>" required></td> <!-- required -->
  </tr>
  <tr>
    <td>Thesis type:</td>
    <!-- required -->
    <td colspan="3"><input type="text" name="thesistype" maxlength="128" value="<?php if($data != null){echo $data->thesistype;} ?>" class="form_input" required></td><td colspan="2"><i>Thesis types: Bachelor of Science, 15hp, Master of Science, 15 hp, Master of Science, 30hp, Master of Science of Engeneering (civilingenj&ouml;r)</i></td>
  </tr>

  <th>Evaluation</th><th></th><th>Value (-,0-5)</th><th>AVG</th><th>TOT</th>
  <tr>
    <td><b>Process</b></td>
    <td>Independence, initiative and creativity</td>
    <td><select name="process1" onchange="average(thesis.process1.value, thesis.process2.value, thesis.process3.value, thesis.process4.value)"><option><?php if($data != null){echo $data->process1;} ?></option><option>-</option><option>0</option><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select></td>
  </tr>
  <tr>
    <td>0.1</td>
    <td> Critical thinking and attitude</td>
    <td><select name="process2" onchange="average(thesis.process1.value, thesis.process2.value, thesis.process3.value, thesis.process4.value)"><option><?php if($data != null){echo $data->process2;} ?></option><option>-</option><option>0</option><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select></td>
  </tr>
  <tr>
    <td></td>
    <td>Planning and execution</td>
    <td><select name="process3" onchange="average(thesis.process1.value, thesis.process2.value, thesis.process3.value, thesis.process4.value)"><option><?php if($data != null){echo $data->process3;} ?></option><option>-</option><option>0</option><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select></td>
  </tr>
  <tr>
    <td></td>
    <td>Openness to critique and</td>
    <td><select name="process4" onchange="average(thesis.process1.value, thesis.process2.value, thesis.process3.value, thesis.process4.value)"><option><?php if($data != null){echo $data->process4;} ?></option><option>-</option><option>0</option><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select></td>
    <td><input type="text" name="s1" id="s1" maxlength="1" value="<?php echo $data->s1; ?>" class="form_input" required></td>
  </tr>

  <tr>
    <td><b>Content</b></td>
    <td> Problem identification and formulation</td>
    <td><select name="content1" onchange="avg_s2(thesis.content1.value, thesis.content2.value, thesis.content3.value)"><option><?php if($data != null){echo $data->content1;} ?></option><option>-</option><option>0</option><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select></td>
  </tr>
  <tr>
    <td>0.4</td>
    <td> Evaluation</td>
    <td><select name="content2" onchange="avg_s2(thesis.content1.value, thesis.content2.value, thesis.content3.value)"><option><?php if($data != null){echo $data->content2;} ?></option><option>-</option><option>0</option><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select></td>
  </tr>
  <tr>
    <td></td>
    <td> Method selection and application</td>
    <td><select name="content3" onchange="avg_s2(thesis.content1.value, thesis.content2.value, thesis.content3.value)"><option><?php if($data != null){echo $data->content3;} ?></option><option>-</option><option>0</option><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select></td>
    <td><input type="text" name="s2" id="s2" maxlength="1" value="<?php echo $data->s2; ?>" class="form_input" required></td>
  </tr>

  <tr>
    <td><b>Contribution</b></td>
    <td>Contribution to reasearch area (Master only)</td>
    <td><select name="contribution1" onchange="avg_s3(thesis.contribution1.value, thesis.contribution2.value, thesis.contribution3.value)"><option><?php if($data != null){echo $data->contribution1;} ?></option><option>-</option><option>0</option><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select></td>
  </tr>
  <tr>
    <td>0.25</td>
    <td>Contribution to reasearch/development (MSE only)</td>
    <td><select name="contribution2" onchange="avg_s3(thesis.contribution1.value, thesis.contribution2.value, thesis.contribution3.value)"><option><?php if($data != null){echo $data->contribution2;} ?></option><option>-</option><option>0</option><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select></td>
  </tr>
  <tr>
    <td></td>
    <td>Synthesis</td>
    <td><select name="contribution3" onchange="avg_s3(thesis.contribution1.value, thesis.contribution2.value, thesis.contribution3.value)"><option><?php if($data != null){echo $data->contribution3;} ?></option><option>-</option><option>0</option><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select></td>
    <td><input type="text" name="s3" id="s3" maxlength="1" value="<?php echo $data->s3; ?>" class="form_input" required></td>
  </tr>

  <tr>
    <td><b>Presentation</b></td>
    <td> Disposition</td>
    <td><select name="presentation1" onchange="average(thesis.presentation1.value, thesis.presentation2.value, thesis.presentation3.value, thesis.presentation4.value, thesis.presentation5.value)"><option><?php if($data != null){echo $data->presentation1;} ?></option><option>-</option><option>0</option><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select></td>
  </tr>
  <tr>
    <td>0.25</td>
    <td> Adherence to formal rules and templates</td>
    <td><select name="presentation2" onchange="average(thesis.presentation1.value, thesis.presentation2.value, thesis.presentation3.value, thesis.presentation4.value, thesis.presentation5.value)"><option><?php if($data != null){echo $data->presentation2;} ?></option><option>-</option><option>0</option><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select></td>
  </tr>
  <tr>
    <td></td>
    <td> Description of work</td>
    <td><select name="presentation3" onchange="average(thesis.presentation1.value, thesis.presentation2.value, thesis.presentation3.value, thesis.presentation4.value, thesis.presentation5.value)"><option><?php if($data != null){echo $data->presentation3;} ?></option><option>-</option><option>0</option><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select></td>
  </tr>
  <tr>
    <td></td>
    <td> Analysis and argumentation</td>
    <td><select name="presentation4" onchange="average(thesis.presentation1.value, thesis.presentation2.value, thesis.presentation3.value, thesis.presentation4.value, thesis.presentation5.value)"><option><?php if($data != null){echo $data->presentation4;} ?></option><option>-</option><option>0</option><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select></td>
  <tr>
    <td></td>
    <td> Language</td>
    <td><select name="presentation5" onchange="average(thesis.presentation1.value, thesis.presentation2.value, thesis.presentation3.value, thesis.presentation4.value, thesis.presentation5.value)"><option><?php if($data != null){echo $data->presentation5;} ?></option><option>-</option><option>0</option><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select></td>
    <td><input type="text" name="s4" id="s4" maxlength="1" value="<?php if($data != null){echo $data->s4;} ?>" class="form_input" required></td>
    <td><input type="text" name="s5" id="s5" maxlength="1" value="<?php if($data != null){echo $data->s5;} ?>" class="form_input" required></td>
  </tr>

  <tr>
    <td><b>Computded grade</b></td><td></td><td></td><td></td><td><input type="text" name="s6" id="s6" maxlength="1" value="<?php if($data != null){echo $data->s6;} ?>" class="form_input" required></td>
  </tr>
  <tr>
    <td><b>Overall impression</b></td><td></td><td></td><td></td><td><textarea name="impression" maxlength="128" rows="1" class="form_input" required><?php if($data != null){echo $data->impression;} ?></textarea></td>
  </tr>

  <tr>
    <td>Reviewer</td>
    <td><input type="text" name="rname" class="form_input" maxlength="128" value="<?php if($data != null){echo $data->rname;} ?>" required></td> <!-- required -->
    <td>Date</td>
    <td><input type="text" name="date" maxlength="10" value="<?php if($data != null){echo $data->date;}else{echo date("d-m-Y");} ?>" class="form_input" required></td> <!-- required -->
  </tr>

  <th>Comments and feedback</th>
  <tr>
    <td colspan="7"><textarea name="feedback" rows="20" maxlength="128" class="form_input" required><?php if($data != null){echo $data->feedback;} ?></textarea></td> <!-- required -->
  </tr>

  <tr>
    <td><input type="submit" name="submit" value="Submit evaluation"></td>
  </tr>


</table>
</form>

<script type="text/javascript" src="includes/java/Form.js"></script>
