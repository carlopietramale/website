	

    <?php
     
    function randomPassword() {
        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }
     
    if($_SERVER['REQUEST_METHOD'] != 'POST')
    {
            header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
            echo "Please use 'POST' as Request Type.";
            exit(1);
    }
     
    if(isset($_SERVER['CONTENT_LENGTH']) && (int) $_SERVER['CONTENT_LENGTH'] > 33000000)
    {
            header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
            echo "Exceeded filesize limit.";
            exit(1);
    }
     
    if(!array_key_exists('upload', $_FILES) && !array_key_exists('url', $_POST))
    {
            header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
            echo "File form name is missing or incorrect.";
            exit(1);
    }
     
    if(array_key_exists('upload', $_FILES))
    {
     
            if($_FILES['upload']['error'] != UPLOAD_ERR_OK)
            {
                    header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
     
                    switch($_FILES['upload']['error'])
                    {
                            case UPLOAD_ERR_NO_FILE:
                                    echo "No file sent.";
                            case UPLOAD_ERR_INI_SIZE:
                            case UPLOAD_ERR_FORM_SIZE:
                                    echo "Exceeded filesize limit.";
                            default:
                                    echo "Unknown error.";
                    }
                    exit(1);
            }
     
     
            $uploadfile = basename($_FILES['upload']['name']);
            $path = $_FILES['upload']['name'];
            $ext = pathinfo($path, PATHINFO_EXTENSION);
     
            $sRandomString = randomPassword();
     
            $destination = $sRandomString . '.' . $ext;
     
            if(move_uploaded_file($_FILES['upload']['tmp_name'], './file/' . $destination))
            {
                    echo "http://url/" . $destination;
                    exit(0);
            }
    } else if(array_key_exists('url', $_POST))
    {
            header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
            echo "Not functional yet.";
    }

