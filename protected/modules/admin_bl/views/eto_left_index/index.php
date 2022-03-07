<?php 
echo '

<HTML>
            <HEAD><TITLE>Global Admin</TITLE>
            </HEAD>

              <FRAMESET ROWS="3%,*" FRAMEBORDER="0" BORDER="0">
              <FRAME SRC="../views/eto_left_index/index-top.html" MARGINWIDTH="0" MARGINHEIGHT="0" SCROLLING="AUTO" NAME="top">
              <FRAMESET COLS="15%,85%" BORDER="0" FRAMEBORDER="0">

              <FRAME SRC="../index.php?r=admin_bl/Eto_left_index/Index&str='.$str.'" NAME="main" MARGINWIDTH="0" MARGINHEIGHT="0">
              <FRAME SRC="index-right.html" NAME="right" MARGINWIDTH="0" MARGINHEIGHT="0"
              SCROLLING="AUTO"></FRAMESET>
              <NOFRAMES><BODY LEFTMARGIN="0" TOPMARGIN="0" MARGINHEIGHT="0"
              MARGINWIDTH="0">
              </BODY></NOFRAMES></FRAMESET>
            </HTML>';
            ?>