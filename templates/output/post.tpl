<?php if ($outputModePost == 'op') { $blocktype = 'thread'; } else { $blocktype = 'replies';} ?>

<?php if ($PostData != 0) {
   $picinfo = "<span class = 'filesize' style='font-size:16px;'>Файл: <a href='{$allPosts[$i][IMG]}' target = _blank>link</a>&nbsp;(<em>{$PostData['picture_info']})</em></span>";
   $picblock = "<span class = 'thumbnailmsg' style = 'font-size:16px;'>Уменьшенная копия. Полное изображение по клику.</span><br /><a href='{$allPosts[$i]['IMG']}' target = _blank><img src='{$allPosts[$i]['IMG']}thumb.jpg' alt='Превью'></a>";}?>

<?php if ($blocktype == 'thread') { $pblock = "<div class='thread'>" ;} else if ($blocktype == 'replies') { $pblock = "<div class='replies'><table><tbody><tr><td class='doubledash'>&gt;&gt;</td><td class='reply'>"; }?>

<div class = '<?php echo $blocktype; ?>'>
   <div class="postheader">
   <span id="subj"><?php echo $allPosts[$i]['TITLE']." "; ?></span>
   <span id="poster"><?php if ($allPosts[$i]['EMAIL'] != '') echo "{$allPosts[$i]['EMAIL']}"; else echo "{$allPosts[$i]['OWNER']} ";?>
   <span id="date"><?php echo "{$allPosts[$i]['TIME']} {$allPosts[$i]['DATA']} "; ?>
   <span class="reflink"><a href="<?php echo "#{$allPosts[$i]['ID']}"; ?>"><?php echo "#{$allPosts[$i]['ID']}"; ?></a></span>&nbsp;&nbsp;
</div>



<div class = '<?php echo $blocktype; ?>'>
    <?php 
    	if ( ($PostData != 0) && ($outputModePost != 'cirno') )
    		echo $picinfo.$picblock;
    ?>
        <?php if (($outputMode != 'thread') && ($outputModePost == 'op')) { echo "
    	   <a href = 'thread.php?hash={$value[HASH]}'>[Ответить]</a>"; } ?>
    </div>
    <?php 
        if ( ($PostData != 0) && ($outputModePost == 'cirno') )
            echo $picinfo.$picblock;
    ?>

    <div class = 'OPblock'>
    	<?php echo "{$allPosts[$i]['TEXT']}"; ?>
    </div>



</div> <br clear='both'>
