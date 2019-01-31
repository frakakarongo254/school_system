$random = substr(number_format(time() * rand(),0,'',''),0,10);
    $insertMailVerify = $this->db->prepare("INSERT INTO mailverify (mailAddress, token, datetime) VALUES (:mailAddress, :token, :date)");
    $insertMailVerify->execute(array(':mailAddress'=>$emailAddress,
                                     ':token'=>$random,
                                     ':date'=>$date));

    $to = $emailAddress;
    $subject = "Activating your Account";
    $body = "Hi, in order to activate your account please visit http://localhost/FinalYear/activation.php?email=".$emailAddress." and fill in the verification code $random";
    if(mail($to, $subject, $body))
    {
        echo ("<p>Message success</p>");
    }
    else {
        echo ("<p>Message fail</p>");
    }









    $message = "Your Activation Code is ".$code."";
$to=$email;
$subject="Activation Code For Talkerscode.com";
$from = 'your email';
$body='Your Activation Code is '.$code.' Please Click On This link <a href="verification.php">Verify.php?id='.$db_id.'&code='.$code.'</a>to activate  your account.';
$headers = "From:".$from;
mail($to,$subject,$body,$headers);

echo "An Activation Code Is Sent To You Check You Emails";