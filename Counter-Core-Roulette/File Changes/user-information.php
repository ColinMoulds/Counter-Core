if(!$as)
{
	$as=generateRandomString(10);	
	mysql_query("UPDATE `users` SET `account_secret`='".$as."' WHERE `steamid`='".$_SESSION["steamid"]."'");
}


And add this to the very bottom of your user-information.php


if (!function_exists('generateRandomString'))
{
    function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}