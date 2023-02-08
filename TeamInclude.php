<?php
//http://localhost/BoudreauDangFlaroMoreiraPeeverAssignment/TeamMain.php
function displayTextArea($TextboxName,$textid,$row, $col,$value="")
{
    echo"<textarea name=\"$TextboxName\" id=$textid rows = $row columns = $col autofocus wrap=\"hard\" spellcheck=\"true\" placeholder = \"enter text here\">";
    echo"$value</textarea>";
};

function WriteHeaders ( $title="Assigment", $Heading="Welcome",$TitleBar="MySite")
{
    echo "
    <!doctype html>
    <html lang = \"en\">
    <head>
        <meta charset = \"UTF-8\">
        <title>$TitleBar</title>\n
        <link rel =\"stylesheet\" type = \"text/css\" href=\"teamStyle.css\"/>
    </head>
    <body>\n
    <h1>$title</h1>
    <h2>$Heading : Braxton Flaro, Kael Moreira, Matthew 
        Peever, Phuong Uyen Dang, Jannick Boudreau</h2>\n
    ";
}

function CreateConnectionObject()
{
    $fh = fopen('auth.txt','r');
    $Host = trim(fgets($fh));
    $UserName = trim(fgets($fh));
    $Password = trim(fgets($fh));
    $Database = trim(fgets($fh));
    $Port = trim(fgets($fh));
    fclose($fh);
    $mysqlObj = new mysqli($Host, $UserName, $Password,$Database,$Port);
    
    $stmt = $mysqlObj->prepare("create database if not exists $Database");
    $dbCreated = $stmt->execute(); 	
    // if the connection and authentication are successful,
    // the error number is 0
    // connect_errno is a public attribute of the mysqli class.
    if ($mysqlObj->connect_errno != 0)
    {
    echo"<p>Connection failed. Unable to open database $Database. Error: "
             . $mysqlObj->connect_error . "</p>";
    // stop executing the php script
    exit;
    }
    return ($mysqlObj);
}   

function  findTextinFileCaseSen($pText)

{
        $pText = trim($pText);
        $filename = 'editor.dat';
        $file = file_get_contents($filename);
        $pos = stripos ($file, $pText);

        $numbPos = $pos + 1;

        if ($pos === false)

        {
            echo "<p> $pText was not found </p>";
        }

        else
        echo "<p> string $pText was found at position $numbPos </p>";
}



function findTextinFileCaseInsen($pText)

{
        $pText = trim($pText);
        $filename = 'editor.dat';
        $file = file_get_contents($filename);
        $pos = stripos ($file, $pText);

        $numbPos = $pos + 1;

        if ($pos === false)
        {
            echo "<p> $pText was not found </p>";
        }
        else
        echo "<p> string $pText was found at position $numbPos </p>";

}

function DataEntryForm ($value = "")
{
        echo "<p>";
        displayTextArea("f_Area","area",40,40,$value);
        echo"</p>
        
        <button type=\"submit\" name=\"f_submit\">Submit</button> ";
}


function showText($value)
{
    echo "<p>";
    echo "<p><div id=\"text\">";
    displayTextArea("f_Area","area",40,40,$value);
    echo"</div>";
    echo"</p>";

}

// Nav Bars

function drawMenu()
{
    echo"<div class=\"navbar\">";
    drawFileDropDown();
    drawEditDropDown();
    drawFontDropDown();
    echo"</div>";
}
function drawFileDropDown()
{
    echo"
    <div class=\"dropdown\">
    <button class=\"dropbtn\">File</button>
    <div class=\"dropdown-content\">
    <form method='post' action=?>
    <div class=\"blockbtn\">
    <button class= \"blockbtn\" classtype=\"submit\" name=\"f_New\"> New </option>
    <button class= \"blockbtn\" classtype=\"submit\" name=\"f_Open\"> Open </option>
    <button class= \"blockbtn\" classtype=\"submit\" name=\"f_Save\"> Save </option>
    </div>
    </div></div>
    ";
}
function drawEditDropDown ()
{
    echo"
    <div class=\"dropdown\">
    <button class=\"dropbtn\">Edit</button>
    <div class=\"dropdown-content\">
    <label>Word Search</label>
    <form method='post' action=?>
    <p><label>Search</label><input type = text
     name = \"f_searchSensitive\" Size = 20></p>
    <input type=\"checkbox\" id=\"caseSens\" 
    name=\"caseSens\" value=\"Sens\"> Case Sensitive </input></p>
    <div class=\"searchbtn\">
    <button class= \"searchbtn\" type=\"submit\" name=\"f_findCaseSensitive\">Find word</button>
    </div>
    
    </div></div>";
}
//line 149
function drawFontDropDown()
{
    $mysqlObj = CreateConnectionObject(); 
    $TableName = "fontNames";
    $query = "SELECT * From $TableName";
    $stmtObj = $mysqlObj->prepare($query);
    $stmtObj->execute();
    $stmtObj->bind_result($fontName);

    echo"<div class=\"dropdown\">
    <button class=\"dropbtn\">Font</button>
    <div class=\"dropdown-content\">
    <label>Font</label>
        <select name=\"font\">";
         while($data = $stmtObj->fetch())
             echo "<option value=\"$fontName\">$fontName</option>";

        echo"
              </select><br><label>Style</label><select name=\"size\">";
        echo "<option value=\"small\">small</option>";
        echo "<option value=\"medium\">medium</option>";
        echo "<option value=\"large\">large</option></select>";
        echo"<button name=\"submit\"type=\"submit\">Set font</button>
        </div></div>";
}

function ChangeStyle($font,$size)
{ 
    echo " <script type=\"text/javascript\">var font = \"$font \";</script>
           <script type=\"text/javascript\">var size = \"$size\";</script>
           <script type=\"text/javascript\" src=\"changeFont.js\"></script>";
}

function saveFile($pWrite)
{
    
    $myFile = fopen("editor.dat", "w");
    $filename = "editor.dat";
    $fileExists = file_exists($filename);
    if($fileExists)
    {
        fwrite($myFile, $pWrite);
        
        echo "File Saved";
    }
    else
        echo "Error Saving File";
    
    
    fclose($myFile);
    
}
function openFile()
{
    $myfile = fopen("editor.dat", "r");
    $filename = "editor.dat";
    
    $fileExists = file_exists($filename);
    if($fileExists)
    {
        showText(fread($myfile, filesize($filename))) . "<br> <br>";
       
    }
    else
        echo "Error Opening File";
    
    fclose($myfile);       
}

?>