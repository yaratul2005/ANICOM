<?php
namespace Core;

class Mailer
{
    /**
     * Send email completely natively avoiding Composer (uses native internal Sendmail/SMTP fallback from PHP.ini)
     */
    public static function send($to, $subject, $message, $isHtml = true)
    {
        $fromEmail = Config::get('mail.from.address', 'hello@example.com');
        $fromName  = Config::get('mail.from.name', Config::get('app.name'));

        // Standard Email Structure Map
        $headers = [];
        $headers[] = "From: {$fromName} <{$fromEmail}>";
        $headers[] = "Reply-To: {$fromEmail}";
        $headers[] = "X-Mailer: ANICOM-Core";

        if ($isHtml) {
            $headers[] = 'MIME-Version: 1.0';
            $headers[] = 'Content-type: text/html; charset=UTF-8';
            
            // Layout wrapping
            $message = self::applyTemplate($subject, $message);
        }

        // Exec native function
        return mail($to, $subject, $message, implode("\r\n", $headers));
    }

    private static function applyTemplate($title, $content)
    {
        $appName = Config::get('app.name');
        return "
        <html>
        <head>
            <style>
                body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background: #f8fafc; margin: 0; padding: 2rem; color: #1e293b; }
                .container { max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; }
                .header { background: #4f46e5; color: #ffffff; padding: 2rem; text-align: center; font-size: 1.5rem; font-weight: bold; }
                .content { padding: 2.5rem 2rem; line-height: 1.6; font-size: 1rem; }
                .footer { background: #f1f5f9; padding: 1.5rem; text-align: center; font-size: 0.85rem; color: #64748b; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>{$appName}</div>
                <div class='content'>
                    <h2 style='margin-top: 0;'>{$title}</h2>
                    {$content}
                </div>
                <div class='footer'>
                    &copy; " . date('Y') . " {$appName}. All rights reserved.<br>
                    You are receiving this because of your activity on our store.
                </div>
            </div>
        </body>
        </html>
        ";
    }
}
