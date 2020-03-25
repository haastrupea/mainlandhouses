<?php

// //config
// include_once 'config/database.php';
// include_once 'lib/database.php';

// $database=$config['database'];
// $dbdriver=$database['driver'];
// $dbname=$database['name'];
// $dbUser=$database['user'];
// $dbPass=$database['password'];

// $dbCon=database::getInstance($dbdriver,$dbname,$dbUser,$dbPass);


// $path="assets/images/houses";

// $files=scandir($path);

// $sql="INSERT IGNORE INTO `House_photo_gallery`(`house_id`,`ext`,`image`) VALUES (:house_id,:fileExt,:file_name)";
// // (:house_id,:ext,:img_name)
// foreach ($files as $file) {
//     $picPath=$path.DIRECTORY_SEPARATOR.$file;
//     $patern="/_(\d)+_/";
//     preg_match($patern,$file,$match);

//     if(!empty($match)){
//         $house_id=str_replace("_","",$match[0]);

//         //extract file extension
//         $fileExt=pathinfo($picPath,PATHINFO_EXTENSION);


//         //encode the file name
//         $fileName=substr(hash('sha256',$file),5,20).".".strtolower($fileExt);

//         //rename the file
//         $newfileNamepath=$path.DIRECTORY_SEPARATOR.$fileName;
//         $error=rename($picPath,$newfileNamepath);
        
//         if(!$error){
//             //add it to db
//             // $dbCon->crudQuery($sql,[":house_id"=>$house_id,":fileExt"=>$fileExt,":file_name"=>$fileName]);
//             echo $file;
//             echo "Inserted Successfully";
//             echo "<br>";
//         }else{
//             echo $file;
//             echo " could not be added to db due to error in renaming";
//             echo "<br>";
//         }

//     }
// }


?>
<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/template/styles/bs/bs.min.css">
    <link rel="stylesheet" href="/template/styles/fa/css/all.min.css">
    <title>Add house to database</title>
</head>
<body>
    <div class="container-fluid">
    <div class="row">
    <form action="#">
    <div class="form-group">
    <div class="input-group">
    
    <input type="text" class="form-control">
    </div>
    </div>
    </form>
    </div>
    </div>
</body>
</html> -->