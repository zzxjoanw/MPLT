<?

function doConnect()
{
    $username = "dcwecddg_mplt";
    $password = "20spring16";
    $host = "localhost";
    $database = "dcwecddg_mplt";
    $connection = new mysqli($host,$username,$password,$database) or die($connection->error);
    
    return $connection;
}

//USER and ADMIN
//--------------
//login()
//logout()


//USER
//----
//if user doesn't exist in system, add them
//register()

//return all languages OR return all languages being learned by the user
function viewLanguages($connection, $user = -1)
{
    if($user==-1)
    {
        $sql = "SELECT languageName FROM languageTable";
        $preparedStatement = $connection->prepare($sql);
    }
    else
    {
        $sql = "SELECT l.languageName FROM languageTable l, courseRegTable c
          WHERE l.languageID = c.languageID AND c.userID = ?";
        $preparedStatement = $connection->prepare($sql);
        var_dump($preparedStatement);
        $preparedStatement->bind_param("i",$user) or die($preparedStatement->error);
    }

    $preparedStatement->execute() or die($preparedStatement->error);
    $preparedStatement->bind_result($name);

    $list = array();

    while($preparedStatement->fetch())
    {
        array_push($list,$name);
    }

    return $list;
}

function viewDialects($connection,$languageID)
{
    $sql = "SELECT name FROM dialectTable WHERE languageID = ?";
    $preparedStatement = $connection->prepare($sql);
    $preparedStatement->bind_param("i",$languageID);
    $preparedStatement->execute();
    $preparedStatement->bind_result($name);

    $list = array();
    while($preparedStatement->fetch())
    {
        array_push($list,$name);
    }

    return $list;
}

//get a pair that's ready to be practiced, and practice it. then put it back in a box
function getPair($connection)
{
    $sql = "SELECT textA,textB,soundA,soundB, b.lastPracticed
            FROM pairTable a,practiceTracker b WHERE a.pairID = b.pairID ORDER BY lastPracticed DESC LIMIT 1";
    
    $preparedStatement = $connection->prepare($sql);
    $preparedStatement->execute();
    $preparedStatement->bind_result($textA,$textB,$soundA,$soundB,$lastPracticed);
    
    $list = array();
    while($preparedStatement->fetch())
    {
        array_push($list,$textA);
        array_push($list,$textB);
        array_push($list,$soundA);
        array_push($list,$soundB);
        array_push($list,$lastPracticed);
    }
    
    return $list;
}

//add the user to a course. create new entries in the practiceTracker table and populate them
function enroll($connection,$userID,$langID,$dialectID)
{
    $sql = "INSERT INTO courseRegTable(userID,languageID,dialectID) VALUES($userID,$langID,$dialectID)";
    $preparedStatement = $connection->prepare($sql);
    $preparedStatement->execute() or die($preparedStatement->error);
    return "success";
}

//remove the user from a course. remove relevant entries from the practiceTracker table
function unenroll($connection,$userID,$languageID,$dialectID)
{
    $sql = "DELETE * FROM courseRegTable WHERE userID = ? AND languageID = ? AND dialectID = ?";
    $preparedStatement = $connection->prepare($sql);
    $preparedStatement->execute() or die($preparedStatement->error);
    return "success";
}

/*
//ADMIN
//-----
//adds a new language
addNewLanguage()

//add a new dialect. must be connected to a specific language that's already in the system
addNewDialect()

//add a new pair, with two strings and two audio files. connected to a specific dialect
addNewPair()

//change a language's name
editLanguage()

//change a dialect's name
editDialect()

//modify a string(s) or audiofile(s) associated with a pair record
editPair()

//add a new box, specifying its interval
addNewBox()

//redefine the interval of an existing box
redefineBox()

//reassign the contents of a box to the next lower box and remove it
removeBox()*/
    ?>