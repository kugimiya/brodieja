<div class = "posting" id="postarea"> <center>
 <!?php if ($index != "true") { echo "<a href = 'index.php' Назад</a"; } ?>
 <form method="post" action=<?php echo "'{$_SERVER['REQUEST_URI']}'"; ?> enctype="multipart/form-data">
  <table>
   <tr>
    <td> Имя : </td>
    <td><input type='text' name='emailblock' size="40" value=""></td>
     <tr>
      <tr>
       <td> Тема : </td>
       <td><input type='text' name='themeblock' size="26" value=""><input type="submit" value="Отправить"></td>
       <tr>	
        <tr>
         <td> Текст : </td>
         <td><textarea name='textblock' cols="60" rows="8" wrap="None"></textarea></td>
        </tr>
	<tr>
         <td> Файл : </td>
         <td><input type="file" name="fileblock"> </td>
        </tr>
  </table>
  <center> <a href="help.html" target=_blank>LurkMoar!</a> </center>
  <table> 
  <tr> 
   <td><span class = 'redsmall'> Запрещено</span></td>
   <td><span class = 'redsmall'>
    <ul>
     <li>Реклама сторонних ресурсов, не относящихся к U-Me Group, Ttd.</li>
     <li>Детская эротика/порнография, педофилия, в т.ч обсуждение сабжа.</li>
     <li>Действия, влекущие за собой сбой ресурса.</li>
     <li>Активная пропаганда <b>любых</b> мнений.</li>
     <li>Рандомного содержания текст.</span></li>
    </ul> 
   </td>
  </tr>
  <tr> 
  <td><br></td>
  <td> <span class = 'small'> 
   <ul>
    <li>Поддерживаемые типы файлов: GIF, JPG, PNG</li>
    <li>Максимальное количество бампов треда: 250</li>
    <li>Максимально допустимый размер файлов: 2500 кБ</li> 
    <li>В случае не соблюдения правил может исчезнуть тред.</span></li> 
   </ul>
  </td>
 </tr>
</table>
</form> 
</center>
</div>
<hr>
