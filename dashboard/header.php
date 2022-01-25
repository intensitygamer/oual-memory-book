<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css">
        <link rel="stylesheet" type="text/css" href="<?php echo OUAL_NAME_APP;?>assets/css/plugin.css">

        <title><?php echo $page_title;?> | Once Upon A Legacy</title>
    </head>
    <body class="memory_book_body<?=$body_class;?>">

<style type="text/css">

.meme-container {
  position: relative;
  text-align: center;
  
}

/* Centered text */
.top_text {
  position: absolute;
  top: 20%;
  left: 50%;
  transform: translate(-50%, -50%);
  color:black;
  font-size:20px;
  font-weight: bold;
  text-shadow: 2px 2px 4px #FFFF00, 2px 2px 4px #FFFF00;
}

.bottom_text {
  position: absolute;
  top: 70%;
  left: 50%;
  transform: translate(-50%, -50%);
  color:black;
  font-size:20px;
  font-weight: bold;
  text-shadow: 2px 2px 4px #FFFF00, 2px 2px 4px #FFFF00;
}
</style>

<?php @$get_user_details = get_user_details_by_email( $_SESSION['user_email'] );?>