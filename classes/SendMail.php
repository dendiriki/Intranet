<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require "vendor/PHPMailer/PHPMailer.php" ;
require 'vendor/PHPMailer/SMTP.php';
require "vendor/PHPMailer/Exception.php" ;

/**
 * Description of SendMail
 *
 * @author dheo
 */
class SendMail {
  //put your code here
  const MAIL_HOST = "202.137.3.89";
  const MAIL_PORT = 25;
  const MAIL_SENDER = "intranet@ispatindo.com";
  const MAIL_SENDER_NAME = "Intranet";
  const INTRANET_URL = "intranet.ispatindo.com/intranet/?action=it_ticket";
  public $errorMessage = null;
  
  const MAIL_HOST1 = "202.137.3.89";
  const MAIL_PORT1 = 25;
  const MAIL_SENDER1 = "indo.it@ispatindo.com";
  const MAIL_SENDER_NAME1 = "INDO IT";
  public $errorMessage1 = null;
  
  const MAIL_HOST2 = "202.137.3.89";
  const MAIL_PORT2 = 25;
  const MAIL_SENDER2 = "indo.purchase@ispatindo.com";
  const MAIL_SENDER_NAME2 = "INDO PURCHASE";
  public $errorMessage2 = null;

  public function __construct() {
    ;
  }
  
  public function sendTheMail($subject, $body, $recipient = array()) {
    $mail = new PHPMailer(true);
    try {
      //Server settings
      //$mail->SMTPDebug = 2; //enable verbose mode
      $mail->SMTPAutoTLS = false; //add by vicky bcs smtp change
      $mail->isSMTP();
      $mail->Host = self::MAIL_HOST;
      $mail->SMTPAuth = false;
      $mail->Port = self::MAIL_PORT;
      //Recipients
      $mail->setFrom(self::MAIL_SENDER, self::MAIL_SENDER_NAME);
      foreach($recipient as $recp){
        $mail->addAddress($recp);
      }

      //Content
      $mail->isHTML(true);
      $mail->Subject = $subject;
      $mail->Body = $body;

      $mail->send();
      return true;
    } catch (Exception $e) {
      $this->errorMessage = $mail->ErrorInfo;
      return false;
    }
  }
	
	public function sendTheMailAdv($subject, $body, $recipient = array()) {
    $mail = new PHPMailer(true);
    try {
      //Server settings
      $mail->SMTPDebug = 2; //enable verbose mode
      $mail->SMTPAutoTLS = false; //add by vicky bcs smtp change
      $mail->isSMTP();
      $mail->Host = self::MAIL_HOST;
      $mail->SMTPAuth = false;
      $mail->Port = self::MAIL_PORT;
      //Recipients
      $mail->setFrom(self::MAIL_SENDER, self::MAIL_SENDER_NAME);
      foreach($recipient as $recp){
				if($recp["type"] == "ADD") {
					$mail->addAddress($recp["email"]);					
				} else if ($recp["type"] == "CC") {
					$mail->addCC($recp["email"]);
				} else if ($recp["type"] == "BCC") {
					$mail->addBCC($recp["email"]);
				}
      }

      //Content
      $mail->isHTML(true);
      $mail->Subject = $subject;
      $mail->Body = $body;

      $mail->send();
      return true;
    } catch (Exception $e) {
      $this->errorMessage = $mail->ErrorInfo;
			error_log($mail->ErrorInfo);
      return false;
    }
  }
  
  public function sendTheMailIT($subject, $body, $recipient = array()) {
    $mail = new PHPMailer(true);
    try {
      //Server settings
      $mail->SMTPDebug = 2; //enable verbose mode
      $mail->SMTPAutoTLS = false; //add by vicky bcs smtp change
      $mail->isSMTP();
      $mail->Host = self::MAIL_HOST1;
      $mail->SMTPAuth = false;
      $mail->Port = self::MAIL_PORT1;
      //Recipients
      $mail->setFrom(self::MAIL_SENDER1, self::MAIL_SENDER_NAME1);
      foreach($recipient as $recp){
				if($recp["type"] == "ADD") {
					$mail->addAddress($recp["email"]);					
				} else if ($recp["type"] == "CC") {
					$mail->addCC($recp["email"]);
				} else if ($recp["type"] == "BCC") {
					$mail->addBCC($recp["email"]);
				}
      }

      //Content
      $mail->isHTML(true);
      $mail->Subject = $subject;
      $mail->Body = $body;

      $mail->send();
      return true;
    } catch (Exception $e) {
      $this->errorMessage1 = $mail->ErrorInfo;
			error_log($mail->ErrorInfo);
      return false;
    }
  }
  
    public function sendTheMailPU($subject, $body, $recipient = array()) {
    $mail = new PHPMailer(true);
    try {
      //Server settings
      $mail->SMTPDebug = 2; //enable verbose mode
      $mail->SMTPAutoTLS = false; //add by vicky bcs smtp change
      $mail->isSMTP();
      $mail->Host = self::MAIL_HOST2;
      $mail->SMTPAuth = false;
      $mail->Port = self::MAIL_PORT2;
      //Recipients
      $mail->setFrom(self::MAIL_SENDER2, self::MAIL_SENDER_NAME2);
      foreach($recipient as $recp){
				if($recp["type"] == "ADD") {
					$mail->addAddress($recp["email"]);					
				} else if ($recp["type"] == "CC") {
					$mail->addCC($recp["email"]);
				} else if ($recp["type"] == "BCC") {
					$mail->addBCC($recp["email"]);
				}
      }

      //Content
      $mail->isHTML(true);
      $mail->Subject = $subject;
      $mail->Body = $body;

      $mail->send();
      return true;
    } catch (Exception $e) {
      $this->errorMessage2 = $mail->ErrorInfo;
			error_log($mail->ErrorInfo);
      return false;
    }
  }
  
  public function sendITTicketMailToUser($ticket_no, $subject, $priority, $status, $req_by_name, $recipient, $category) {
    $mail = new PHPMailer(true);
    $ticket = new ItInquiry();
    $employee = new Employee();
    $priority_text = $ticket->getPriorityById($priority);
    $status_text = $ticket->getStatusById($status);
    $category_text = $ticket->getSupCategoryById($category);
    $pic = $ticket->getTicketPIC($ticket_no);
    $pic_mail = null;
    if(isset($pic["pic"])) {
      $pic_mail = $employee->getMailById($pic["pic"]);
    }
    $reply = $ticket->getReply($ticket_no);
    
    try {
      //Server settings
      //$mail->SMTPDebug = 3; //enable verbose mode
      $mail->isSMTP();
      $mail->SMTPAutoTLS = false;
      $mail->Host = gethostbyname(self::MAIL_HOST);
      $mail->SMTPAuth = false;
      $mail->Port = self::MAIL_PORT;
      //Recipients
      $mail->setFrom(self::MAIL_SENDER, self::MAIL_SENDER_NAME);
      if(is_array($recipient)) {
        foreach($recipient as $recp){
          $mail->addAddress($recp);
        }
      } else {
        $mail->addAddress($recipient);
      }      
      
      if(!empty($pic_mail)) {
        $mail->addCC($pic_mail);
      }
      //Content
      $mail->isHTML(true);
      $mail->Subject = "[".$status_text["desc"]."][".$category_text["desc"]."] IT Ticketing System Notification, Ticket No.".$ticket_no;
      $body = "<html>"
              . "<head>"
              . "<style>"
              . "body {font-family: 'Calibri', arial, sans-serif;}"
              . "pre {font-family: 'Calibri', arial, sans-serif;}"
              . "</head>"
              . "<body>";
      $body .= "Dear ".$req_by_name.",<br><br>
              Terima kasih atas kepercayaannya telah menggunakan IT Ticketing System.<br> 
              Sesuai dengan laporan yang sudah kami terima, berikut kami sampaikan tiket pengaduan sebagai referensi case tersebut :<br> 
              <br>
              <table>
              <tr><td>Ticket No</td><td>:</td><td>".$ticket_no."</td></tr>
              <tr><td>Category</td><td>:</td><td>".$category_text["desc"]."</td></tr>
              <tr><td>Subject</td><td>:</td><td>".$subject."</td></tr>
              <tr><td>Priority</td><td>:</td><td>".$priority_text["desc"]."</td></tr> 
              <tr><td>Status</td><td>:</td><td>".$status_text["desc"]."</td></tr> 
              ";
      if(!empty($pic["name"])) {
        $body .= "<tr><td>PIC</td><td>:</td><td>".$pic["name"]."</td></tr>";
      }
      $body .= "</table>
              <br>";
      if(count($reply) > 0) {
        $body .= "<table>";
        $body .= "<tr><th>Reply</th><th>By</th><th>Date</th></tr>";
        foreach($reply as $rpl) {
          $body .= "<tr><td><pre>".$rpl["reply"]."</pre></td><td>".$rpl["reply_name"]."</td><td>".$rpl["date"]."</td></tr>";
        }
        $body .= "</table><br>";
      }
      $body .="Untuk melihat lebih detail tiket, anda dapat mengakses <a href='".self::INTRANET_URL."'>IT Ticketing System</a><br>
              Demikian kami sampaikan.<br>
              Terima kasih atas perhatian dan kerja samanya.";
      
      $body .= "</body>"
              . "</html>";
      $mail->Body = $body;

      if(count($recipient) > 0) {
        $mail->send();
        return true;
      } else {
        $this->errorMessage = "MAIL ERROR : recipient empty";
        error_log($this->errorMessage);
        return false;
      }
      
    } catch (Exception $e) {
      $this->errorMessage = "MAIL ERROR : ".$mail->ErrorInfo;
      error_log($this->errorMessage);
      return false;
    }
  }
  
  public function sendITTicketMailToIT($ticket_no, $subject, $priority, $req_by_name, $recipient, $category) {
    $mail = new PHPMailer(true);
    $ticket = new ItInquiry();
    $user = new User();
    $employee = new Employee();
    $priority_text = $ticket->getPriorityById($priority);
    $category_text = $ticket->getSupCategoryById($category);
    try {
      //Server settings
      //$mail->SMTPDebug = 3; //enable verbose mode
      $mail->isSMTP();
      $mail->SMTPAutoTLS = false;
      $mail->Host = gethostbyname(self::MAIL_HOST);
      $mail->SMTPAuth = false;
      $mail->Port = self::MAIL_PORT;
      //Recipients
      $mail->setFrom(self::MAIL_SENDER, self::MAIL_SENDER_NAME);
      
      if(is_array($recipient)) {
        foreach($recipient as $recp){
          $mail->addAddress($recp);
        }
      } else {
        $mail->addAddress($recipient);
      }
      //semua pengaduan cc ke HOD
      //if($priority == "H") {
        $it_hod_list = $user->getUserListByRole("5");
        $it_hod = null;
        if(!empty($it_hod_list)) {
          foreach($it_hod_list as $ihl) {
            $it_hod = $ihl["username"];
          }
          $email_hod = $employee->getMailById($it_hod);
          $mail->addCC($email_hod);
        }
      //}
      //Content
      $mail->isHTML(true);
      $mail->Subject = "[".$category_text["desc"]."] IT Ticketing System Notification, Ticket No.".$ticket_no;
      $mail->Body = "Dear IT Team,<br><br>
                    Sesuai dengan laporan yang sudah diterima IT Ticketing System, berikut kami sampaikan tiket pengaduan sebagai berikut :<br> 
                    <br>
                    <table>
                    <tr><td>Ticket No</td><td>:</td><td>".$ticket_no."</td></tr>
                    <tr><td>On Behalf</td><td>:</td><td>".$req_by_name."</td></tr>
                    <tr><td>Category</td><td>:</td><td>".$category_text["desc"]."</td></tr>
                    <tr><td>Subject</td><td>:</td><td>".$subject."</td></tr> 
                    <tr><td>Priority</td><td>:</td><td>".$priority_text["desc"]."</td></tr> 
                    </table><br>
                    Untuk melihat detail dan memulai penanganan tiket anda dapat mengakses <a href='".self::INTRANET_URL."'>IT Ticketing System</a><br>
                    Demikian kami sampaikan.<br>
                    Terima kasih atas perhatian dan kerja samanya.";
      if(count($recipient) > 0) {
        $mail->send();
        return true;
      } else {
        $this->errorMessage = "MAIL ERROR : recipient empty";
        error_log($this->errorMessage);
        return false;
      }
    } catch (Exception $e) {
      $this->errorMessage = "MAIL ERROR : ".$mail->ErrorInfo;
      error_log($this->errorMessage);
      return false;
    }
  }
}
