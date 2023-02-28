<?php

include('includes/cors.php');
include('includes/host.php');

$message = "error creating new database";
exit(json_encode(
    array(
        'status' => 400,
        'message' => $_POST

    )

));
if (isset($_POST['site_name'])) {
 
    $site_name = $_POST['site_name'];
    $user_email = $_POST['email'];
    $user_password = $_POST['password']; //bycrypted password sent
    $con = new mysqli($host, $user, $password);

    $create = $con->query("CREATE DATABASE $site_name");

    if ($create) {
        //load sql file

        if ($create) {
            try {

                // Temporary variable, used to store current query
                $templine = '';
                // Read in entire file
                $filename = __DIR__ . '/includes/sql/saas_sql.sql';
                $lines = file($filename);
                //  Loop through each line
                foreach ($lines as $line) {
                    $startWith = substr(trim($line), 0, 2);
                    $endWith = substr(trim($line), -1, 1);
                    // Skip it if it's a comment
                    if (empty($line) || $startWith == '--' || $startWith == '/*' || $startWith == '//')

                        continue;

                    // Add this line to the current segment
                    $templine .= $line;
                    // If it has a semicolon at the end, it's the end of the query
                    if (substr(trim($line), -1, 1) == ';') {
                        // Perform the query
                        $conn_2 = mysqli_connect($host, $user, $password, $site_name);

                        $sql = $conn_2->query($templine) or print('Error performing query \'<strong>' . $templine . '\': <br /><br />');
                        // Reset temp variable to empty
                        $templine = '';


                        $con_2 = new mysqli($host, $user, $password, $site_name);
                        $time = new DateTime();
                        $user_token = "qwertyuioadsghzvgdfuypbmcbjhcba$time";
                        $token = str_shuffle($user_token);
                        $token = substr($user_token, 4, 12);
                        //insert values bycrypted password
                        $save_user = $con_2->query("INSERT INTO users (email,name,password,role,token,created_at) VALUES ('$user_email','$site_name','$user_password','__admin','$token',NOW() ) ");
                    
                        if ($save_user) {
                            exit(json_encode(
                                array(
                                    'status' => 200,
                                    'message' => 'Database created successfully',
                                    'token' => $token
                                )

                            ));
                        } else {
                            exit(json_encode(
                                array(
                                    'status' => 200,
                                    'message' => 'there was an error occurred'

                                )

                            ));
                        }
                    }
                }
            } catch (Exception $e) {
                
                exit(json_encode(
                    array(
                        'status' => 400,
                        'message' =>  $e->getMessage()

                    )

                ));
            }
        } else {
            $message = "error creating new database";
            exit(json_encode(
                array(
                    'status' => 400,
                    'message' => $message

                )

            ));
        }
    }
}
