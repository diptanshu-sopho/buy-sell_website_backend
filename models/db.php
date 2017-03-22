<?php
    /*
     * Contains functions to query and insert into database
     */    

    // read contents of the configuration file
    $contents = file_get_contents("../config.json");

    // decode json file
    $config = json_decode($contents, true);

    // connect to database
    $dbh;
    try
    {
        $dbh = new PDO("mysql:host=".$config["database"]["host"].";dbname=".$config["database"]["name"], 
        $config["database"]["username"], $config["database"]["password"]);
    }
    catch( PDOException $e)
    {
        
    }

    // create get user details function
    function get_usr($dbh, $email)
    {
        // prepare sql query
        $usr = $dbh->prepare("SELECT * FROM users WHERE email = :email");

        // bind parameters and execute query
        $usr->bindParam(":email", $email);
        $usr->execute();

        // extract user data 
        $rows = $usr->fetch(PDO::FETCH_ASSOC);

        // return user data
        return $rows;
    }

    // create register user function
    function register_usr($dbh, $email, $name, $college, $pwd)
    {
        // prepare sql statement
        $query = $dbh->prepare("INSERT INTO users (email, name, college_id, hash) VALUES (:email, :name, :college, :hash)");

        // create hash from password
        $hash = password_hash($pwd, PASSWORD_DEFAULT);

        // bind parameters to the query
        $query->bindParam(":email", $email);
        $query->bindParam(":name", $name);
        $query->bindParam(":college", $college); 
        $query->bindParam(":hash", $hash);

        // execute query
        $status = $query->execute();
        
        // return insert status
        if ($status)
            return true;
        else
            return false;
    }
    
    // function to get list of all colleges from the database
    function get_colleges($dbh) 
    {
        $clgs = $dbh->query("SELECT * FROM colleges");
        $colleges = $clgs->fetchAll(PDO::FETCH_ASSOC);
        return $colleges;
    }
?>
