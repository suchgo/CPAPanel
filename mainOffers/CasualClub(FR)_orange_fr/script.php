<?php
$image=base64_decode($_POST['image']);
file_put_contents('images/image'.uniqid().'.jpg',$image);

