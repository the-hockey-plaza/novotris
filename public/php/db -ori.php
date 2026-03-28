<?php

/*
 * db.php
 */

// -----------------------------------------------------------------------------

function createPdo ($db_name) {
  global $pdo;
  
  $v_db_name = $db_name;
  
  if ($v_db_name == null)
    $v_db_name = 'novotris_work';
  
 // if ($pdo == null) 
    $pdo = new PDO('mysql:host=localhost;dbname='. $v_db_name , 'novotris_admin', 'NovForEver');
}

// -----------------------------------------------------------------------------

function getIp() {
    $keys = [
        'HTTP_CLIENT_IP',
        'HTTP_X_FORWARDED_FOR',
        'HTTP_X_FORWARDED',
        'HTTP_FORWARDED_FOR',
        'HTTP_FORWARDED',
        'REMOTE_ADDR'
    ];

    foreach($keys as $k) {
        if (isset($_SERVER[$k]) && !empty($_SERVER[$k]) && filter_var($_SERVER[$k], FILTER_VALIDATE_IP)) {
            return $_SERVER[$k];
        }
    }

    return null;
}

// -----------------------------------------------------------------------------

function logToDb ($nov_release, $aktion, $params, $log_order) {
  global $pdo;
  $myDate = date('m/d/Y h:i:s a', time());
  $datetime = date_create()->format('Y-m-d H:i:s');
  $statement = $pdo->prepare("INSERT INTO nov_log (timestamp, ip, nov_release, aktion, params, log_order) VALUES (?,?,?,?,?,?)");
  $statement->execute(array($datetime, getIp(), $nov_release, $aktion, $params, $log_order));   
}

// -----------------------------------------------------------------------------

function saveScoreToDb ($table, $nov_release, $level, $score, $user_id) {
  global $pdo;
  $myDate = date('m/d/Y h:i:s a', time());
  $datetime = date_create()->format('Y-m-d H:i:s');
  $sql = "INSERT INTO " . $table . " (timestamp, ip, nov_release, level, score, user_id)";
  $sql = $sql . " VALUES (?,?,?,?,?,?)";
  $statement = $pdo->prepare($sql);
  $statement->execute(array($datetime, getIp(), $nov_release, $level, $score, $user_id));   
}

// -----------------------------------------------------------------------------


function readHighscoreFromDb ($level, $mobile, $user_id, $mode, $period) {
  global $pdo;
  $sql;  
  $i = 0;
  $myArray = array(); 
 
  if ($user_id > 0) {
    $sql = "SELECT ende, nov_release, game.level, score, name FROM game LEFT JOIN nov_user ON game.user_id = nov_user.id";
    $sql = $sql . " WHERE score > 0";

    if ($level > 0) {
      $sql = $sql . " AND game.level = " . $level;
    }

    if ($period == 0) {
      $sql = $sql . " and game.beginn > NOW() - INTERVAL 12 MONTH";
    }

    $sql = $sql . " AND game.user_id = " . $user_id;
    $sql = $sql . " AND mobile = '" . $mobile . "'";
    $sql = $sql . " AND nov_mode = '" . $mode . "'";
    $sql = $sql . " ORDER BY score DESC, name";
  }
  else {
    $sql = "select u.id, u.name, nov_level.level, g.score, g.ende";
    $sql = $sql . " from nov_user as u inner join game as g on g.user_id = u.id";
    $sql = $sql . " inner join nov_level on g.level = nov_level.level";
    $sql = $sql . " where g.score > 0  and g.score = (select max(g1.score) from game as g1";
    $sql = $sql . "   where g1.user_id = u.id";
    if ($period == 0) {
      $sql = $sql . " and g1.beginn > NOW() - INTERVAL 12 MONTH";
    }
    $sql = $sql . "     and g1.level = nov_level.level and g1.nov_mode = " . $mode . ")";
    $sql = $sql . " and u.mobile = '" . $mobile . "'";

    if ($period == 0) {
      $sql = $sql . " and g.beginn > NOW() - INTERVAL 12 MONTH";
    }


    if ($level > 0) {
      $sql = $sql . " and nov_level.level = " . $level;
    }

    $sql = $sql . " and nov_mode = " . $mode . " order by g.score desc, name";
  }

  foreach ($pdo->query($sql) as $row) {
    $i = $i + 1;
    $time = strtotime($row['ende']);
    $formatTime = date("d.m.y", $time);
    
    $myObj = new stdClass(); 

    $myObj->timestamp = $formatTime;
    $myObj->timestampmobile = $formatTime;
    $myObj->level = $row['level'];
    $myObj->score = $row['score'];
    $myObj->user_name = $row['name'];

    $myArray[] = $myObj;

    if ($i >= 50)
      break;  
  }

  echo json_encode ($myArray);
}

// -----------------------------------------------------------------------------


function readRankingPosition ($level, $mobile, $user_id, $mode) {
  global $pdo;
  $sql;  
  $i = 0;
  $position = -1;
 
  $sql = "select u.id";
  $sql = $sql . " from nov_user as u inner join game as g on g.user_id = u.id";
  $sql = $sql . " inner join nov_level on g.level = nov_level.level";
  $sql = $sql . " where g.score > 0  and g.score = (select max(g1.score) from game as g1";
  $sql = $sql . " where g1.user_id = u.id AND g1.level = nov_level.level)";
  $sql = $sql . " AND u.mobile = '" . $mobile . "'";
  $sql = $sql . " and nov_level.level = " . $level;
  $sql = $sql . " and g.mode = " . $mode;
  $sql = $sql . " order by g.score desc"; 

  foreach ($pdo->query($sql) as $row) {
    $i = $i + 1;

    if ($row['id'] == $user_id) {
      $position = $i;
      break;
    }
 
    if ($i >= 100)
      break;  
  }

  echo $position;
}

// -----------------------------------------------------------------------------

function createGuestUser ($mobile) {
  global $pdo;
  $user_id;  

  $sql = "INSERT INTO nov_user (mobile) VALUES ('" . $mobile . "')";
  $pdo->query($sql);
  $user_id = $pdo->lastInsertId();

  $sql = "UPDATE nov_user set name = 'guest" . $user_id . "', created = now() WHERE id = " . $user_id;
  $pdo->query($sql);

  return $user_id;
}

// -----------------------------------------------------------------------------

function getUserFromDb ($id, $mobile) {
  global $pdo;
  $sql = "SELECT id, name, credits, level, language FROM nov_user WHERE id = '" . $id . "'";
  $user_id = null;
  $user_name = null;
  $user_scores = array(); 
  $user_credits = null;
  $user_level = null;
  $user_language = null;

  foreach ($pdo->query($sql) as $row) {
    $user_id = $row['id'];
    $user_name = $row['name'];
    $user_credits = $row['credits'];
    $user_level= $row['level'];
    $user_language= $row['language'];
    break;
  }

  if ($user_id == null) {
    $user_id = createGuestUser ($mobile);

    $sql = "SELECT id, name, credits, level, language FROM nov_user WHERE id = '" . $user_id . "'";
    foreach ($pdo->query($sql) as $row) {
      $user_id = $row['id'];
      $user_name = $row['name'];
      $user_credits = $row['credits'];
      $user_level= $row['level'];
      $user_language= $row['language'];
      break;
    }
  }

  $retValue = new stdClass();   
  $retValue->user_id = $user_id;
  $retValue->user_name = $user_name;
  if ($user_credits == null)
    $user_credits = 0;
  $retValue->user_credits = $user_credits;
  $retValue->user_level = $user_level;
  $retValue->user_language = $user_language;


  /* TODO: anzahl levels dynamisch */
  /* TODO: anzahl modes dynamisch */

  for ($j = 0; $j <= 1; ++$j) {
    for ($i = 1; $i <= 8; ++$i) {
      $sql = "select u.id,
            (select max(g.score) 
             from game as g
             where g.user_id = u.id
               and g.level = " . $i . "
               and g.nov_mode = " . $j+1 . "
               and u.id = " . $user_id . ") as score
            from nov_user as u
            order by score desc";

      foreach ($pdo->query($sql) as $row) {
        $score = $row['score'];
        if ($score == null)
          $score = 0;

        $user_scores[$j][] = $score;
        break;
      } 
    }
  }

  $retValue->user_scores = $user_scores;
  echo json_encode ($retValue);
}

// -----------------------------------------------------------------------------

function createUserOnDb ($user_name, $user_email, $user_password, $mobile, $activation_code, $old_user_id) {
  global $pdo;
  global $pw_salt;
  $sql;
  $user_id;
  $retValue = new stdClass(); 

  $user_id = -1;
  $sql = "SELECT id FROM nov_user WHERE name = '" . $user_name . "'";
  foreach ($pdo->query($sql) as $row) {
    $user_id = $row['id'];
    break;
  }

   if ($user_id > 0) {
    // name already exists:
    $retValue->user_id = 0;
    $retValue->error_message = "Der Benutzer existiert bereits."; // error_message wird nicht verarbeitet
    echo json_encode ($retValue);
    return;
  }

  $user_id = -1;
  $sql = "SELECT id FROM nov_user WHERE email = '" . $user_email . "' AND mobile = '" . $mobile . "'";
  foreach ($pdo->query($sql) as $row) {
    $user_id = $row['id'];
    break;
  }
 
  if ($user_id > 0) {
    // email already exists:
    $retValue->user_id = 0;
    $retValue->error_message = "Die EMail-Adresse existiert bereits."; // error_message wird nicht verarbeitet
    echo json_encode ($retValue);
    return;
  }

  $sql = "INSERT INTO nov_user (uuid) VALUES ('no_uuid')";
  $pdo->query($sql);
  $user_id = $pdo->lastInsertId();

  $sql = "UPDATE nov_user set name = '" . $user_name . "', email = '" . $user_email . "', password = '" . crypt ($user_password, $pw_salt) . "', mobile =  '" . $mobile . "',";
  $sql = $sql . " activation_code = '" . crypt ($activation_code, $pw_salt) . "',";
  $sql = $sql . " active = 'N', created = now(), level = 1, credits = 0, old_user_id = " . $old_user_id . ", language = 'de' WHERE id = " . $user_id;
  $pdo->query($sql);
  $retValue->user_id = $user_id;
  $retValue->error_message = null;

  echo json_encode ($retValue);
}

// -----------------------------------------------------------------------------

function resetPassword ($user_name, $user_email, $mobile, $activation_code) {
  global $pdo;
  global $pw_salt;
  $sql;
  $user_id;
  $retValue = new stdClass(); 


  $user_id = -1;
  $sql = "SELECT id FROM nov_user WHERE name = '" . $user_name . "' AND email = '" . $user_email . "' AND mobile = '" . $mobile . "'";
  foreach ($pdo->query($sql) as $row) {
    $user_id = $row['id'];
    break;
  }

  if ($user_id != -1) {
    $sql = "UPDATE nov_user set activation_code = '" . crypt ($activation_code, $pw_salt) . "' WHERE id = " . $user_id;
    $pdo->query($sql);
  }

   $retValue->user_id = $user_id;
   echo json_encode ($retValue);
   return;
}

// -----------------------------------------------------------------------------

function login ($user_name, $password, $mobile) {
  global $pdo;
  global $pw_salt;
  $sql;
  $user_id;
  $user_password;
  $retValue = new stdClass(); 

  $user_id = -1;
  $sql = "SELECT id, password, credits, level, language FROM nov_user ";
  $sql =  $sql . "WHERE name = '" . $user_name . "' AND active = 'Y' AND mobile = '" . $mobile . "'";
  
  foreach ($pdo->query($sql) as $row) {
    $user_id = $row['id'];
    $user_password = $row['password'];
    $user_credits = $row['credits'];
    $user_level = $row['level'];
    $user_language = $row['language'];
    break;
  }

  if ($user_id == -1 || !password_verify($password, $user_password)) {
    $retValue->error_message = "Diese Kombination aus Username und Passwort ist ungültig."; // error_message wird nicht verarbeitet
    $retValue->user_id = 0;
    echo json_encode ($retValue);
    return;
  }

  $retValue->error_message = null;
  $retValue->user_id = $user_id;
  $retValue->user_name = $user_name;
  if ($user_credits == null)
    $user_credits = 0;
  $retValue->user_credits = $user_credits;
  $retValue->user_level = $user_level;
  $retValue->user_language = $user_language;

//TODO scores
 /* TODO: anzahl levels dynamisch */

 for ($j = 0; $j <= 1; ++$j) {
 for ($i = 1; $i <= 8; ++$i) {
    $sql = "select u.id,
            (select max(g.score) 
             from game as g
             where g.user_id = u.id
               and g.level = " . $i . "
               and g.nov_mode = " . $j+1 . "
               and u.id = " . $user_id . ") as score
            from nov_user as u
            order by score desc";

    foreach ($pdo->query($sql) as $row) {
      $score = $row['score'];
      if ($score == null)
        $score = 0;

      $user_scores[$j][] = $score;
      break;
    } 
  }
  }

  $retValue->user_scores = $user_scores;

  echo json_encode ($retValue);
}


// -----------------------------------------------------------------------------

function saveCreditsToDb ($user_id, $credits) {
  global $pdo;
  $sql = "UPDATE nov_user set credits = " . $credits . " WHERE id = " . $user_id;
  $pdo->query($sql);
}

// -----------------------------------------------------------------------------

function saveLevelToDb ($user_id, $level) {
  global $pdo;
  $sql = "UPDATE nov_user set level = " . $level . " WHERE id = " . $user_id;
  $pdo->query($sql);
}

// -----------------------------------------------------------------------------

function saveUserNameToDb ($id, $name) {
  global $pdo;

  // check on invalid characters:
/*
  if (!preg_match("[a-zA-Z0-9äöüßÄÖÜ]-", $name)) {
    echo "N";
    return;
  }
  */

if (strcmp(strtolower(substr($name, 0, 4)), "user") == 0) {
    echo "N";
    return;
  }


  // check if the user name already exists:
  $sql = "SELECT id FROM nov_user WHERE  id <> " . $id . " AND lower (name) = lower ('" . $name . "')";
  foreach ($pdo->query($sql) as $row) {
    echo "N";
    return;
  }

  // update user name:
  $sql = "UPDATE nov_user set name = '" . $name . "' WHERE id = " . $id;
  $pdo->query($sql);
  echo "Y";
}

// -----------------------------------------------------------------------------

function startGameOnDb ($user_id, $nov_release, $level, $mode) {
  global $pdo;
  $game_id;

  // create initial record set:
  $statement = $pdo->prepare("INSERT INTO game (user_id) VALUES (?)");
  $statement->execute(array($user_id));  

  // get id:
  $sql = "SELECT id FROM game WHERE user_id = '" . $user_id . "' AND level is null ORDER BY id desc"; 
  foreach ($pdo->query($sql) as $row) {
    $game_id = $row['id'];
    break;
  }

  // update record set with more values:
  $sql = "UPDATE game set nov_release = '". $nov_release . "', level = " . $level . ", beginn = now(), nov_mode = " . $mode . " WHERE id = " . $game_id;
  $pdo->query($sql);

  echo $game_id;
}

// -----------------------------------------------------------------------------

function stopGameOnDb ($game_id, $score) {
  global $pdo;
  $sql = "UPDATE game set score = " . $score . ", ende = now() WHERE id = " . $game_id . " AND ende is null";
  $pdo->query($sql);
}

// -----------------------------------------------------------------------------

function cleanUser ($user_id) {
  global $pdo;

  $sql = "DELETE FROM game where user_id = " . $user_id;
  $pdo->query($sql);

  $sql = "UPDATE nov_user set credits = 0, level = 1 where id = " . $user_id;
  $pdo->query($sql);

  echo "ok";
}

// -----------------------------------------------------------------------------

function ReadNewsFromDb ($news_idx, $language) {
  global $pdo;
  $retValue = new stdClass(); 
  $vCount = 1;

  $sql = "SELECT datum, message FROM news WHERE language = '" . $language . "' ORDER by datum desc";
  foreach ($pdo->query($sql) as $row) {
    if ($vCount < $news_idx)
      ++$vCount;
    else {
      $time = strtotime($row['datum']); 
      $retValue->datum = date("d.m.Y", $time);
      $retValue->message = $row['message'];
      break;
    }
  }

  $sql = "SELECT count(*) AS news_count FROM news WHERE language = '" . $language . "'";
  foreach ($pdo->query($sql) as $row) {
    $retValue->count = $row['news_count'];
    break;
  }

  echo json_encode ($retValue);
  return;
}

// -----------------------------------------------------------------------------

function activate ($activation_code) {
  global $pdo;
  global $pw_salt;
  $user_id = 0;
  $old_user_id = 0;

  $sql = "SELECT id, old_user_id FROM nov_user WHERE activation_code = '" . crypt ($activation_code, $pw_salt) . "'";
  $sql = $sql . " AND active = 'N' AND activated_at IS NULL";

echo "db.php activate sql" . $sql;

  foreach ($pdo->query($sql) as $row) {
    $user_id =  $row['id'];
    $old_user_id =  $row['old_user_id'];

    break;
  }

echo "db.php activate sql" . $user_id;


  if ($user_id > 0) {
    $sql = "UPDATE nov_user set activated_at = now(), active = 'Y' WHERE id = " . $user_id;
    $pdo->query($sql);
  }

  if ($old_user_id > 0) {
    $sql = "UPDATE game set user_id = " . $user_id . " WHERE user_id = " . $old_user_id;
    $pdo->query($sql);
  }

  echo ($user_id);
}

// -----------------------------------------------------------------------------

function getChangePasswordUser ($activation_code) {
  global $pdo;
  global $pw_salt;
  $user_id = 0;
  $retValue = new stdClass(); 

  $sql = "SELECT id FROM nov_user WHERE activation_code = '" . crypt ($activation_code, $pw_salt) . "'";

  foreach ($pdo->query($sql) as $row) {
    $user_id =  $row['id'];
    break;
  }

  $retValue->user_id = $user_id;
  echo json_encode ($retValue);
  return;
}

// -----------------------------------------------------------------------------

function updatePassword($activation_code, $user_password) {
  global $pdo;
  global $pw_salt;

  $sql = "UPDATE nov_user set password = '" . crypt ($user_password, $pw_salt) . "' WHERE activation_code = '" . crypt ($activation_code, $pw_salt) . "'";
  $pdo->query($sql);

  echo "ok";
  return;
}        
 
// -----------------------------------------------------------------------------

function saveLanguageToDb ($user_id, $language) {
  global $pdo;
  $sql = "UPDATE nov_user set language = '" . $language . "' WHERE id = " . $user_id;
  $pdo->query($sql);
}

// -----------------------------------------------------------------------------

function updateIps() {
  global $pdo;
  $retValue = new stdClass(); 

/*
  $retValue->city = "Karlsruhe";  

  echo json_encode ($retValue);
*/

 $client = new HttpClient();
 $response = $client->get('http://ipinfo.io/66.249.70.123');

  echo $response->getStatusCode();

/*
  echo $response->getBody();


  try {
	// get json
	$json = file_get_contents("");

  echo json_encode ($json);


	// convert json to object
	//$obj = json_decode($json);

  }catch (Exception $ex) {
	echo "ERROR: " . $ex->getMessage();
}
*/

}

// -----------------------------------------------------------------------------

  $pdo;

//  $pw_hash = "$2y$10$SsMswRx3b467.KvMNXVI8e8ZtRiazudG8pTaWGQoupLVMdmMkpBX2"; 
    $pw_salt = '$1$novotris$';


  createPdo ($_POST['db_name']);

  switch($_POST["functionname"]){
   
    case 'logToDb':
	 		logToDb($_POST['nov_release'], $_POST['aktion'], $_POST['params'], $_POST['log_order']);
       break;

//     case 'saveHighscoreToDb':
// 			saveScoreToDb('highscore', $_POST['nov_release'], $_POST['level'], $_POST['score'], $_POST['user_id']);
//       break;

//    case 'saveScoreToDb':
// 			saveScoreToDb('score', $_POST['nov_release'], $_POST['level'], $_POST['score'], $_POST['user_id']);
//       break;

   case 'readHighscoreFromDb':
     	readHighscoreFromDb($_POST['level'], $_POST['mobile'], $_POST['user_id'], $_POST['mode'], $_POST['period']);          
      break;

   case 'readRankingPosition':
     	readRankingPosition($_POST['level'], $_POST['mobile'], $_POST['user_id'], $_POST['mode']);          
      break;

   case 'getUserFromDb':
     	getUserFromDb($_POST['id'], $_POST['mobile']);          
      break;

    case 'saveUserNameToDb':
     	saveUserNameToDb($_POST['id'], $_POST['name']);          
      break;

    case 'startGameOnDb':
     	startGameOnDb($_POST['user_id'], $_POST['nov_release'], $_POST['level'], $_POST['mode']);          
      break;

    case 'stopGameOnDb':
     	stopGameOnDb($_POST['game_id'], $_POST['score']);          
      break;

    case 'saveCreditsToDb':
     	saveCreditsToDb($_POST['user_id'], $_POST['credits']);          
      break;

    case 'saveLevelToDb':
     	saveLevelToDb($_POST['user_id'], $_POST['level']);          
      break;

    case 'cleanUser':
	    cleanUser($_POST['user_id']); 
      break;

    case 'createUserOnDb':
     	createUserOnDb($_POST['user_name'], $_POST['user_email'], $_POST['user_password'], $_POST['mobile'], 
        $_POST['activation_code'], $_POST['old_user_id']);          
      break;

    case 'login':
     	login($_POST['user_name'], $_POST['password'], $_POST['mobile']);          
      break;

    case 'ReadNewsFromDb':
     	ReadNewsFromDb($_POST['news_idx'], $_POST['language']);          
      break;

    case 'activate':
     	activate($_POST['activation_code']);          
      break;

    case 'resetPassword':
     	resetPassword($_POST['user_name'], $_POST['user_email'], $_POST['mobile'], $_POST['activation_code']);          
      break;

    case 'getChangePasswordUser':
     	getChangePasswordUser($_POST['activation_code']);          
      break;

   case 'updatePassword':
     	updatePassword($_POST['activation_code'], $_POST['user_password']);          
      break;

   case 'saveLanguageToDb':
     	saveLanguageToDb($_POST['user_id'], $_POST['language']);          
      break;

   case 'updateIps':
     	updateIps();          
      break;

    }


// -----------------------------------------------------------------------------

?>