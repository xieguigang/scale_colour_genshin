<?php

include_once __DIR__ . "/PHPMailer/src/Exception.php";
include_once __DIR__ . "/PHPMailer/src/PHPMailer.php";
include_once __DIR__ . "/PHPMailer/src/POP3.php";
include_once __DIR__ . "/PHPMailer/src/SMTP.php";

class EMail {
		
    /**
     * 引入PHPMailer发送邮件
	 * 
	 * @param string $to 收件人
	 * @param string $name 对方的姓名称呼
	 * @param string $title 邮件的标题
	 * @param string $content 邮件的正文
	 * @param array $link ``[button_title => link]``, 邮件之中的链接按钮
	 * @param array|string $attachmentLink 附件的文件路径或者一个字典数组，例如["report.pdf" => "/folder/T2018XXXXXX.pdf"]
	 * 
	 * @return string|boolean 如果发送成功，则只会返回一个逻辑值``true``，反之失败会返回错误信息 
    */
    public static function sendMail($to, $name, $title, $content, $link, $attachmentLink = NULL) {
        $mail = new \PHPMailer(); 
		$config = DotNetRegistry::Read("mailer");
		
        $mail->isSMTP();              // 使用SMTP服务
        $mail->CharSet = "UTF-8";     // 编码格式为utf8，不设置编码的话，中文会出现乱码       
        $mail->Host = $config["server"];   // 发送方的SMTP服务器地址
        $mail->SMTPAuth = true;       // 是否使用身份验证
        $mail->Username = $config["user"]; // 发送方的163邮箱用户名
        $mail->Password = $config["password"];  // 发送方的邮箱密码，注意用163邮箱这里填写的是“客户端授权密码”而不是邮箱的登录密码！
        $mail->SMTPSecure = "ssl";    // 使用ssl协议方式
        $mail->Port = $config["port"];

		// 设置发件人信息，如邮件格式说明中的发件人，这里会显示为Mailer(xxxx@163.com），Mailer是当做名字显示
        $mail->setFrom($config["user"], "管理员");
        $mail->addAddress($to);                               // 设置收件人信息，如邮件格式说明中的收件人，这里会显示为Liang(yyyy@163.com)
        # $mail->addReplyTo("xxxx", "Reply");   // 设置回复人信息，指的是收件人收到邮件后，如果要回复，回复邮件将发送到的邮箱地址
		
		// 添加附件,并指定名称	
		if (!empty($attachmentLink)) {

			// 如果参数是字符串，则解析出文件名
			if (is_string($attachmentLink)) {
				$fileName = basename($attachmentLink);
				$path     = $attachmentLink;
			} else {
				// 如果是数组字典格式，则应该是
				//
				// [fileName => filePath]
				//
				$fileName = array_keys($attachmentLink)[0];
				$path     = $attachmentLink[$fileName];
			}
			
			$mail->addAttachment($path, $fileName); 
		}
        
        $mail->isHTML(true);

        $content = self::buildMailPage($name, $to, $title, $content, $link);
		
        $mail->Subject = $title;   // 邮件标题        
        $mail->MsgHTML($content);  // 识别html代码
       
        if ($mail->send()) {
            return true;
        } else {
            return "Mailer Error: " . $mail->ErrorInfo;
        }
    }
	
	public static function buildMailPage($name, $email, $title, $content, $link) {
		$time = date('Y-m-d H:i:s');
		$html = file_get_contents(__DIR__ . "/views/etc/mail.html");
		
		list($linkTitle, $linkURL) = Utils::Tuple($link);

		if (!$name) {
			$name = explode("@", $email)[0];			
		}
		
		$html = str_replace("\$name",       $name,      $html);
		$html = str_replace("\$title",      $title,     $html);
		$html = str_replace("\$content",    $content,   $html);
		$html = str_replace("\$time",       $time,      $html);
		$html = str_replace("\$link.url",   $linkURL,   $html);
		$html = str_replace("\$link.title", $linkTitle, $html);
		$html = str_replace("\$email",      $email,     $html);
		
		return $html;
	}
}