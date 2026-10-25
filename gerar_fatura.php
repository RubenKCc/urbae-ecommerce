<?php
require '.ht_conexao-bd.php';
require 'vendor/autoload.php';

use Mpdf\Mpdf;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

function gerar_e_enviar_fatura($carrinho_id, $conexao, $idioma = 'pt') {

    $sql = "SELECT c.*, u.utilizador, u.email, u.id_utilizadores
            FROM carrinho c 
            JOIN utilizadores u ON c.utilizador_id = u.id_utilizadores 
            WHERE c.id = $carrinho_id";
    $res = mysqli_query($conexao, $sql);
    $carrinho = mysqli_fetch_assoc($res);
    if (!$carrinho) return false;

    $sql_itens = "SELECT ci.quantidade, ci.preco_total_itens, p.designacao, p.designacao_en, p.preco
                  FROM carrinho_itens ci
                  JOIN produtos p ON ci.produto_id = p.id
                  WHERE ci.carrinho_id = $carrinho_id";
    $res_itens = mysqli_query($conexao, $sql_itens);
    $itens = [];
    while ($item = mysqli_fetch_assoc($res_itens)) {
        $itens[] = $item;
    }

    $data = date('d/m/Y');
    $hora = date('H:i');
    $num_fatura = 'URB-' . str_pad($carrinho_id, 6, '0', STR_PAD_LEFT);
    $num_cliente = 'CLI-' . str_pad($carrinho['id_utilizadores'], 5, '0', STR_PAD_LEFT);
    $total_com_iva = $carrinho['preco_total_carrinho'];
    $total_sem_iva = $total_com_iva / 1.23;
    $valor_iva = $total_com_iva - $total_sem_iva;

    // TEXTOS PT/EN
    if ($idioma === 'en') {
        $txt_fatura    = 'INVOICE';
        $txt_doc       = 'Billing document';
        $txt_fatura_n  = 'Invoice No.';
        $txt_cliente_n = 'Client No.';
        $txt_data      = 'Date';
        $txt_hora      = 'Time';
        $txt_pago      = '✓ PAID';
        $txt_emitido   = 'Issued by';
        $txt_faturado  = 'Billed to';
        $txt_num_cli   = 'Client No.';
        $txt_emissao   = 'Issue Date';
        $txt_valor     = 'Amount Due';
        $txt_desc      = 'Description';
        $txt_qtd       = 'Qty';
        $txt_preco_u   = 'Unit Price excl. VAT';
        $txt_iva       = 'VAT';
        $txt_val_iva   = 'VAT Amount';
        $txt_total_iva = 'Total incl. VAT';
        $txt_sub       = 'Subtotal excl. VAT';
        $txt_envio     = 'Shipping';
        $txt_gratis    = 'Free';
        $txt_total_f   = 'TOTAL WITH VAT';
        $txt_rod1      = 'This document is valid as proof of payment.';
        $txt_rod2      = 'Electronically processed invoice';
        $txt_email_sub = "URBÆ Invoice — $num_fatura";
        $txt_email_ola = 'Hello';
        $txt_email_msg = 'Thank you for your purchase! Please find your invoice attached.';
        $txt_email_nf  = 'Invoice No.';
        $txt_email_tot = 'Total Paid';
        $txt_email_iva = 'VAT included (23%)';
        $txt_email_anx = 'The PDF invoice is attached to this email.';
        $txt_nome_pdf  = "Invoice_{$num_fatura}.pdf";
    } else {
        $txt_fatura    = 'FATURA';
        $txt_doc       = 'Documento de cobrança';
        $txt_fatura_n  = 'Fatura Nº';
        $txt_cliente_n = 'Nº Cliente';
        $txt_data      = 'Data';
        $txt_hora      = 'Hora';
        $txt_pago      = '✓ PAGO';
        $txt_emitido   = 'Emitido por';
        $txt_faturado  = 'Faturado a';
        $txt_num_cli   = 'Nº Cliente';
        $txt_emissao   = 'Data de Emissão';
        $txt_valor     = 'Valor a Pagar';
        $txt_desc      = 'Descrição';
        $txt_qtd       = 'Qtd';
        $txt_preco_u   = 'Preço Unit. s/ IVA';
        $txt_iva       = 'IVA';
        $txt_val_iva   = 'Valor IVA';
        $txt_total_iva = 'Total c/ IVA';
        $txt_sub       = 'Subtotal sem IVA';
        $txt_envio     = 'Envio';
        $txt_gratis    = 'Grátis';
        $txt_total_f   = 'TOTAL COM IVA';
        $txt_rod1      = 'Este documento é válido como comprovativo de pagamento.';
        $txt_rod2      = 'Fatura processada electronicamente';
        $txt_email_sub = "Fatura URBÆ — $num_fatura";
        $txt_email_ola = 'Olá';
        $txt_email_msg = 'Obrigado pela sua compra! Em anexo encontra a sua fatura.';
        $txt_email_nf  = 'Nº Fatura';
        $txt_email_tot = 'Total Pago';
        $txt_email_iva = 'IVA incluído (23%)';
        $txt_email_anx = 'A fatura em PDF está em anexo neste email.';
        $txt_nome_pdf  = "Fatura_{$num_fatura}.pdf";
    }

    // LINHAS DOS ITENS
    $linhas_itens = '';
    foreach ($itens as $item) {
        $nome = ($idioma === 'en' && !empty($item['designacao_en'])) ? $item['designacao_en'] : $item['designacao'];
        $preco_unit_sem_iva = $item['preco'] / 1.23;
        $preco_total_sem_iva = $preco_unit_sem_iva * $item['quantidade'];
        $iva_item = $item['preco_total_itens'] - $preco_total_sem_iva;

        $linhas_itens .= "
        <tr>
            <td style='padding:10px 8px; border-bottom:1px solid #eee;'>$nome</td>
            <td style='padding:10px 8px; border-bottom:1px solid #eee; text-align:center;'>{$item['quantidade']}</td>
            <td style='padding:10px 8px; border-bottom:1px solid #eee; text-align:right;'>" . number_format($preco_unit_sem_iva, 2, ',', '.') . " €</td>
            <td style='padding:10px 8px; border-bottom:1px solid #eee; text-align:center;'>23%</td>
            <td style='padding:10px 8px; border-bottom:1px solid #eee; text-align:right;'>" . number_format($iva_item, 2, ',', '.') . " €</td>
            <td style='padding:10px 8px; border-bottom:1px solid #eee; text-align:right; font-weight:bold;'>" . number_format($item['preco_total_itens'], 2, ',', '.') . " €</td>
        </tr>";
    }

    $html = "
    <!DOCTYPE html>
    <html>
    <head><meta charset='UTF-8'></head>
    <body style='font-family: Arial, sans-serif; font-size: 12px; color: #333; margin:0; padding:0;'>

    <table width='100%' style='background:#1a472a; padding:15px 20px;' cellpadding='0' cellspacing='0'>
        <tr>
            <td style='color:#fff; font-size:28px; font-weight:bold; letter-spacing:4px;'>URBÆ</td>
            <td style='text-align:right; color:#fff;'>
                <span style='font-size:18px; font-weight:bold; text-transform:uppercase; letter-spacing:2px;'>$txt_fatura</span><br>
                <span style='font-size:11px; opacity:0.8;'>$txt_doc</span>
            </td>
        </tr>
    </table>

    <table width='100%' style='background:#f5f5f5; padding:10px 20px; border-bottom:1px solid #ddd;' cellpadding='0' cellspacing='0'>
        <tr>
            <td style='font-size:11px; color:#555;'>
                <strong>$txt_fatura_n:</strong> $num_fatura &nbsp;&nbsp;
                <strong>$txt_cliente_n:</strong> $num_cliente &nbsp;&nbsp;
                <strong>$txt_data:</strong> $data &nbsp;&nbsp;
                <strong>$txt_hora:</strong> $hora
            </td>
            <td style='text-align:right;'>
                <span style='background:#1a472a; color:#fff; padding:4px 12px; font-size:11px; font-weight:bold;'>$txt_pago</span>
            </td>
        </tr>
    </table>

    <table width='100%' style='padding:20px; border-bottom:2px solid #000;' cellpadding='0' cellspacing='0'>
        <tr>
            <td width='50%' style='vertical-align:top; padding-right:20px;'>
                <div style='font-size:10px; text-transform:uppercase; letter-spacing:1px; color:#999; margin-bottom:6px;'>$txt_emitido</div>
                <div style='font-size:14px; font-weight:bold; color:#1a472a;'>URBÆ</div>
                <div style='font-size:11px; color:#555; line-height:1.8; margin-top:4px;'>
                    N1, Coimbra, Portugal<br>urbaegeral@gmail.com<br>911-825-589
                </div>
            </td>
            <td width='50%' style='vertical-align:top; border-left:1px solid #eee; padding-left:20px;'>
                <div style='font-size:10px; text-transform:uppercase; letter-spacing:1px; color:#999; margin-bottom:6px;'>$txt_faturado</div>
                <div style='font-size:14px; font-weight:bold; color:#000;'>{$carrinho['utilizador']}</div>
                <div style='font-size:11px; color:#555; line-height:1.8; margin-top:4px;'>
                    {$carrinho['email']}<br>$txt_num_cli: $num_cliente
                </div>
            </td>
        </tr>
    </table>

    <table width='100%' style='margin:15px 0; padding:0 20px;' cellpadding='0' cellspacing='0'>
        <tr>
            <td>
                <table width='100%' style='background:#f9f9f9; border:1px solid #eee; padding:12px;' cellpadding='6' cellspacing='0'>
                    <tr>
                        <td style='font-size:11px; color:#999; text-transform:uppercase; letter-spacing:1px;'>$txt_fatura</td>
                        <td style='font-size:11px; color:#999; text-transform:uppercase; letter-spacing:1px;'>$txt_emissao</td>
                        <td style='font-size:11px; color:#999; text-transform:uppercase; letter-spacing:1px;'>$txt_cliente_n</td>
                        <td style='font-size:11px; color:#999; text-transform:uppercase; letter-spacing:1px; text-align:right;'>$txt_valor</td>
                    </tr>
                    <tr>
                        <td style='font-size:13px; font-weight:bold;'>$num_fatura</td>
                        <td style='font-size:13px; font-weight:bold;'>$data</td>
                        <td style='font-size:13px; font-weight:bold;'>$num_cliente</td>
                        <td style='font-size:16px; font-weight:bold; color:#1a472a; text-align:right;'>" . number_format($total_com_iva, 2, ',', '.') . " €</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <table width='100%' style='border-collapse:collapse; margin:0 0 15px 0;' cellpadding='0' cellspacing='0'>
        <thead>
            <tr style='background:#000; color:#fff;'>
                <th style='padding:10px 8px; text-align:left; font-size:11px; text-transform:uppercase; letter-spacing:1px;'>$txt_desc</th>
                <th style='padding:10px 8px; text-align:center; font-size:11px; text-transform:uppercase; letter-spacing:1px;'>$txt_qtd</th>
                <th style='padding:10px 8px; text-align:right; font-size:11px; text-transform:uppercase; letter-spacing:1px;'>$txt_preco_u</th>
                <th style='padding:10px 8px; text-align:center; font-size:11px; text-transform:uppercase; letter-spacing:1px;'>$txt_iva</th>
                <th style='padding:10px 8px; text-align:right; font-size:11px; text-transform:uppercase; letter-spacing:1px;'>$txt_val_iva</th>
                <th style='padding:10px 8px; text-align:right; font-size:11px; text-transform:uppercase; letter-spacing:1px;'>$txt_total_iva</th>
            </tr>
        </thead>
        <tbody>$linhas_itens</tbody>
    </table>

    <table width='100%' cellpadding='0' cellspacing='0' style='margin-bottom:20px;'>
        <tr>
            <td width='55%'></td>
            <td width='45%'>
                <table width='100%' style='border-collapse:collapse;' cellpadding='0' cellspacing='0'>
                    <tr style='background:#f5f5f5;'>
                        <td style='padding:8px 12px; font-size:12px; color:#555;'>$txt_sub</td>
                        <td style='padding:8px 12px; font-size:12px; text-align:right; color:#555;'>" . number_format($total_sem_iva, 2, ',', '.') . " €</td>
                    </tr>
                    <tr>
                        <td style='padding:8px 12px; font-size:12px; color:#555;'>$txt_iva (23%)</td>
                        <td style='padding:8px 12px; font-size:12px; text-align:right; color:#555;'>" . number_format($valor_iva, 2, ',', '.') . " €</td>
                    </tr>
                    <tr>
                        <td style='padding:8px 12px; font-size:12px; color:#555;'>$txt_envio</td>
                        <td style='padding:8px 12px; font-size:12px; text-align:right; color:#555;'>$txt_gratis</td>
                    </tr>
                    <tr style='background:#1a472a;'>
                        <td style='padding:12px; font-size:14px; font-weight:bold; color:#fff;'>$txt_total_f</td>
                        <td style='padding:12px; font-size:14px; font-weight:bold; color:#fff; text-align:right;'>" . number_format($total_com_iva, 2, ',', '.') . " €</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <table width='100%' style='border-top:2px solid #1a472a; padding-top:15px; margin-top:10px;' cellpadding='0' cellspacing='0'>
        <tr>
            <td style='text-align:center; font-size:10px; color:#aaa; line-height:1.8;'>
                URBÆ — N1, Coimbra, Portugal | urbaegeral@gmail.com | 911-825-589<br>
                $txt_rod1<br>
                $txt_rod2 — $txt_fatura_n $num_fatura | $txt_cliente_n $num_cliente
            </td>
        </tr>
    </table>

    </body>
    </html>";

    $mpdf = new Mpdf(['margin_left'=>10,'margin_right'=>10,'margin_top'=>10,'margin_bottom'=>10,'format'=>'A4']);
    $mpdf->WriteHTML($html);
    $pdf_path = sys_get_temp_dir() . "/fatura_{$num_fatura}.pdf";
    $mpdf->Output($pdf_path, 'F');

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'alexandre.moreira.paulino@gmail.com';
        $mail->Password   = 'SUA_PASSWORD_AQUI';
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;
        $mail->setFrom('alexandre.moreira.paulino@gmail.com', 'URBÆ');
        $mail->addAddress($carrinho['email'], $carrinho['utilizador']);
        $mail->Subject = $txt_email_sub;
        $mail->isHTML(true);
        $mail->Body = "
        <div style='font-family:Arial,sans-serif; max-width:550px; margin:auto; border:1px solid #eee;'>
            <div style='background:#1a472a; padding:25px 30px;'>
                <h1 style='color:#fff; margin:0; font-size:26px; letter-spacing:4px;'>URBÆ</h1>
            </div>
            <div style='padding:30px;'>
                <p style='font-size:15px;'>$txt_email_ola <strong>{$carrinho['utilizador']}</strong>,</p>
                <p>$txt_email_msg</p>
                <div style='background:#f9f9f9; border-left:4px solid #1a472a; padding:15px 20px; margin:20px 0;'>
                    <div style='font-size:12px; color:#999; margin-bottom:5px;'>$txt_email_nf</div>
                    <div style='font-size:16px; font-weight:bold;'>$num_fatura</div>
                    <div style='font-size:12px; color:#999; margin-top:10px; margin-bottom:5px;'>$txt_email_tot</div>
                    <div style='font-size:22px; font-weight:bold; color:#1a472a;'>" . number_format($total_com_iva, 2, ',', '.') . " €</div>
                    <div style='font-size:11px; color:#999; margin-top:5px;'>$txt_email_iva</div>
                </div>
                <p style='font-size:12px; color:#999;'>$txt_email_anx</p>
            </div>
            <div style='background:#f5f5f5; padding:15px 30px; text-align:center; font-size:11px; color:#aaa;'>
                URBÆ — N1, Coimbra, Portugal | urbaegeral@gmail.com
            </div>
        </div>";
        $mail->AltBody = "$txt_email_ola {$carrinho['utilizador']}, $txt_email_nf $num_fatura. $txt_email_tot: " . number_format($total_com_iva, 2, ',', '.') . " €";
        $mail->addAttachment($pdf_path, $txt_nome_pdf);
        $mail->send();
        unlink($pdf_path);
        return true;
    } catch (Exception $e) {
        return false;
    }
}