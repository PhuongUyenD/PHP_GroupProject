<?php
//part A - Yannik, Matthew
//Part B - Braxton
//Part C - Kael, Phoung
//https://localhost/BoudreauDangFlaroMoreiraPeeverAssignment/TeamMain.php
Include_once('TeamInclude.php');
   //main

   WriteHeaders ("Team Assigment","Team members:", "Team Assigment");
   echo "<form action = ? method=post>";
   drawMenu();


   //first -- function drawFileDropDown()
 
    if (isset($_POST['f_New']))
    {
        DataEntryForm(); 

    }
    else if (isset($_POST['f_Save']))
    {
       DataEntryForm(file_get_contents("editor.dat")); // added blank initial text to dataentryform to get file content
                                                       //so we dont need to have anything in it but can
    }
    else if (isset($_POST['f_Open']))
    {               
        openFile();              
    }

      else if(isset($_POST['f_submit']))
   {
       
       $data = $_POST['f_Area'];
       saveFile($data);
   }

   //second -- drawEditDropDown ()
    if (isset($_POST['f_findCaseSensitive']))
   {
        if (isset($_POST['caseSens'])){
            $findtext = $_POST['f_searchSensitive'];
            findTextinFileCaseSen ($findtext);
        }
        else {
            $findtext = $_POST['f_searchSensitive'];
            findTextinFileCaseInsen ($findtext);         
        }
      
   }  
   
   //partB font button
   if(isset($_POST['submit']))
   { 
       openFile(); 
       $font = $_POST['font']; 
       $size = $_POST['size'];
       ChangeStyle($font,$size);
   }
   echo "</form>";

?>
