
<?php
session_start();
require_once('../v3-php-sdk-2.2.0-RC/config.php');

require_once(PATH_SDK_ROOT . 'Core/ServiceContext.php');
require_once(PATH_SDK_ROOT . 'PlatformService/PlatformService.php');
require_once(PATH_SDK_ROOT . 'Utility/Configuration/ConfigurationManager.php');
require_once(PATH_SDK_ROOT . 'Core/OperationControlList.php');

// Tell us whether to use your QBO vs QBD settings, from App.config
$serviceType = IntuitServicesType::QBO;

// Get App Config
$realmId = ConfigurationManager::AppSettings('RealmID');
if (!$realmId)
	exit("Please add realm to App.Config before running this sample.\n");

// Prep Service Context
$requestValidator = new OAuthRequestValidator(ConfigurationManager::AppSettings('AccessToken'),
                                              ConfigurationManager::AppSettings('AccessTokenSecret'),
                                              ConfigurationManager::AppSettings('ConsumerKey'),
                                              ConfigurationManager::AppSettings('ConsumerSecret'));
$serviceContext = new ServiceContext($realmId, $serviceType, $requestValidator);
if (!$serviceContext)
	exit("Problem while initializing ServiceContext.\n");

// Prep Platform Services
$platformService = new PlatformService($serviceContext);

// Get App Menu HTML
$Respxml = $platformService->Reconnect();

if ($Respxml->ErrorCode != '0')
{

	echo "Error! Reconnection failed..";
	
	if ($Respxml->ErrorCode  == '270')
	{
		echo "OAuth Access Token Rejected! <br />";
	}
	else if($Respxml->ErrorCode  == '212')
	{
		echo "Token Refresh Window Out of Bounds! The request is made outside the 30-day window bounds. <br />";
	}
	else if($Respxml->ErrorCode  == '24')
	{
		echo "Invalid App Token! <br />";
	}
	
}
else
{
	echo "Reconnect successful! Please go back and update the app.config file with the new oAuth tokens.<br />";
}
echo "ResponseXML: ";
var_dump( $Respxml);

echo "<br /> <br /><a href=\"http://localhost:8080/PHPOAuthSample/index.php?connectWithIntuitOpenId\">Go Back</a>";
echo '&nbsp;&nbsp;&nbsp;';
echo '<a target="_blank" href="http://localhost:8080/PHPOAuthSample/ReadMe.htm">Read Me</a><br />';


?>
