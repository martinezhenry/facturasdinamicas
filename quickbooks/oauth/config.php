<?php
  // setting up session
  /* note: This is not a secure way to store oAuth tokens. You should use a secure
  *     data sore. We use this for simplicity in this example.
  */
 // session_save_path('/tmp');
  session_start();

  define('OAUTH_CONSUMER_KEY', 'qyprdPDVJg0VBRwe6Rk2pEEvLixAH7');
  define('OAUTH_CONSUMER_SECRET', 'UzGvy7Cgm6ylA2F0vUzpZUHoF3YI70gX7U8ueUsD');
  
  
  if(strlen(OAUTH_CONSUMER_KEY) < 5 OR strlen(OAUTH_CONSUMER_SECRET) < 5 ){
    echo "<h3>Set the consumer key and secret in the config.php file before you run this example</h3>";
  }
  
 ?>
