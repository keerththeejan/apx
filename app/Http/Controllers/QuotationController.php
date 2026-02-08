<?php

namespace App\Http\Controllers;

use App\Models\Dealer;
use App\Models\QuotationRate;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class QuotationController extends Controller
{
    /**
     * Calculate quotation: rate (country + service) × qty = total.
     * Returns customer unit price, dealer unit price, qty, total (customer), total (dealer).
     */
    public function calculate(Request $request)
    {
        $data = $request->validate([
            'rate_id' => ['required', 'exists:quotation_rates,id'],
            'qty' => ['required', 'numeric', 'min:0.01', 'max:99999'],
            'dealer_code' => ['nullable', 'string', 'max:60'],
        ]);

        $rate = QuotationRate::with('dealers')->findOrFail($data['rate_id']);
        $qty = (float) $data['qty'];
        $dealerCode = trim((string) ($data['dealer_code'] ?? ''));
        $dealer = $dealerCode !== '' ? Dealer::findByCode($dealerCode) : null;
        $dealerApplied = $dealer !== null && $rate->allowsDealer($dealer);

        $result = [
            'country' => $rate->country,
            'service' => $rate->service,
            'customer_unit_price' => (float) $rate->customer_price,
            'dealer_unit_price' => (float) $rate->dealer_price,
            'qty' => $qty,
            'total_customer' => round((float) $rate->customer_price * $qty, 2),
            'total_dealer' => round((float) $rate->dealer_price * $qty, 2),
            'dealer_applied' => $dealerApplied,
            'dealer_code_entered' => $dealerCode !== '',
        ];

        if ($request->wantsJson()) {
            return response()->json($result);
        }

        Session::put('quotation_result', $result);

        return redirect()->back()
            ->withFragment('quote')
            ->withInput($request->only('rate_id', 'qty', 'dealer_code'));
    }

    /**
     * Download quotation as PDF (letterhead with company logo). Requires session quotation_result.
     */
    public function downloadPdf()
    {
        $result = Session::get('quotation_result');
        if (!$result) {
            return redirect()->back()->withFragment('quote')->with('error', 'Get a quotation first.');
        }
        $logoDataUri = $this->getLogoDataUri();
        $viewData = [
            'country' => $result['country'] ?? '',
            'service' => $result['service'] ?? '',
            'qty' => $result['qty'] ?? 0,
            'customer_unit_price' => $result['customer_unit_price'] ?? 0,
            'dealer_unit_price' => $result['dealer_unit_price'] ?? 0,
            'total_customer' => $result['total_customer'] ?? 0,
            'total_dealer' => $result['total_dealer'] ?? 0,
            'dealer_applied' => $result['dealer_applied'] ?? false,
            'date' => now()->format('Y-m-d H:i'),
            'logo_data_uri' => $logoDataUri,
        ];
        try {
            if (!class_exists(\Barryvdh\DomPDF\Facade\Pdf::class)) {
                return redirect()->back()->withFragment('quote')->with('error', 'PDF support not installed. Run: composer require barryvdh/laravel-dompdf');
            }
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('quotation-pdf', $viewData);
            $filename = 'quotation-' . preg_replace('/[^a-zA-Z0-9\-]/', '_', ($result['country'] ?? '') . '-' . ($result['service'] ?? '')) . '-' . date('Y-m-d-His') . '.pdf';
            return $pdf->download($filename);
        } catch (\Throwable $e) {
            return redirect()->back()->withFragment('quote')->with('error', 'PDF could not be generated: ' . $e->getMessage());
        }
    }

    private function getLogoDataUri(): ?string
    {
        $logoUrl = optional(Setting::where('key', 'logo_url')->first())->value;
        if (!$logoUrl) {
            return null;
        }
        $path = public_path(ltrim(preg_replace('#^/public#', '', $logoUrl), '/'));
        if (!is_file($path)) {
            return null;
        }
        $mime = mime_content_type($path);
        $data = base64_encode(file_get_contents($path));
        return 'data:' . $mime . ';base64,' . $data;
    }

    /**
     * Download quotation as PNG image (letterhead with company logo). Requires session quotation_result.
     */
    public function downloadImage()
    {
        $result = Session::get('quotation_result');
        if (!$result) {
            return redirect()->back()->withFragment('quote')->with('error', 'Get a quotation first.');
        }
        $logoPath = $this->getLogoPath();
        $logoImg = null;
        $logoH = 0;
        if ($logoPath && is_file($logoPath)) {
            $ext = strtolower(pathinfo($logoPath, PATHINFO_EXTENSION));
            if (in_array($ext, ['png'], true)) {
                $logoImg = @imagecreatefrompng($logoPath);
            } elseif (in_array($ext, ['jpg', 'jpeg'], true)) {
                $logoImg = @imagecreatefromjpeg($logoPath);
            } elseif ($ext === 'webp' && function_exists('imagecreatefromwebp')) {
                $logoImg = @imagecreatefromwebp($logoPath);
            }
            if ($logoImg) {
                $logoH = min(70, imagesy($logoImg));
                $logoScaled = imagescale($logoImg, min(200, imagesx($logoImg)), $logoH);
                if ($logoScaled) {
                    imagedestroy($logoImg);
                    $logoImg = $logoScaled;
                }
            }
        }
        $w = 500;
        $h = 320 + $logoH;
        $img = @imagecreatetruecolor($w, $h);
        if (!$img) {
            return redirect()->back()->withFragment('quote')->with('error', 'Image generation not available.');
        }
        $bg = imagecolorallocate($img, 255, 255, 255);
        $text = imagecolorallocate($img, 30, 41, 59);
        $gray = imagecolorallocate($img, 100, 116, 139);
        imagefill($img, 0, 0, $bg);
        $y = 20;
        if ($logoImg) {
            $lw = imagesx($logoImg);
            imagecopy($img, $logoImg, 20, 10, 0, 0, $lw, imagesy($logoImg));
            imagedestroy($logoImg);
            $y += 70 + 16;
        }
        $font = 5;
        imagestring($img, $font, 20, $y, 'Quotation', $text);
        $y += 28;
        imagestring($img, $font, 20, $y, 'Country: ' . ($result['country'] ?? ''), $gray);
        $y += 24;
        imagestring($img, $font, 20, $y, 'Service: ' . ($result['service'] ?? ''), $gray);
        $y += 24;
        imagestring($img, $font, 20, $y, 'Total Weight: ' . ($result['qty'] ?? '') . ' kg', $gray);
        $y += 24;
        $unitPrice = !empty($result['dealer_applied']) ? ($result['dealer_unit_price'] ?? 0) : ($result['customer_unit_price'] ?? 0);
        $totalPrice = !empty($result['dealer_applied']) ? ($result['total_dealer'] ?? 0) : ($result['total_customer'] ?? 0);
        imagestring($img, $font, 20, $y, 'Price per kg: ' . number_format($unitPrice, 0), $gray);
        $y += 24;
        imagestring($img, $font, 20, $y, 'Total Price: ' . number_format($totalPrice, 0), $text);
        $y += 24;
        $y += 16;
        imagestring($img, 4, 20, $y, 'Generated ' . now()->format('Y-m-d H:i'), $gray);
        ob_start();
        imagepng($img);
        $png = ob_get_clean();
        imagedestroy($img);
        $filename = 'quotation-' . preg_replace('/[^a-zA-Z0-9\-]/', '_', ($result['country'] ?? '') . '-' . ($result['service'] ?? '')) . '-' . date('Y-m-d-His') . '.png';
        return response($png, 200, [
            'Content-Type' => 'image/png',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    private function getLogoPath(): ?string
    {
        $logoUrl = optional(Setting::where('key', 'logo_url')->first())->value;
        if (!$logoUrl) {
            return null;
        }
        $path = public_path(ltrim(preg_replace('#^/public#', '', $logoUrl), '/'));
        return is_file($path) ? $path : null;
    }

    /**
     * Download quotation as text document (.txt) for WhatsApp or sharing.
     */
    public function downloadText()
    {
        $result = Session::get('quotation_result');
        if (!$result) {
            return redirect()->back()->withFragment('quote')->with('error', 'Get a quotation first.');
        }
        $unitPrice = !empty($result['dealer_applied']) ? ($result['dealer_unit_price'] ?? 0) : ($result['customer_unit_price'] ?? 0);
        $totalPrice = !empty($result['dealer_applied']) ? ($result['total_dealer'] ?? 0) : ($result['total_customer'] ?? 0);
        $lines = [
            'QUOTATION',
            '================',
            'Country: ' . ($result['country'] ?? ''),
            'Service: ' . ($result['service'] ?? ''),
            'Total Weight: ' . ($result['qty'] ?? '') . ' kg',
            'Price per kg: ' . number_format($unitPrice, 0),
            'Total Price: ' . number_format($totalPrice, 0),
            '',
            'Generated ' . now()->format('Y-m-d H:i'),
        ];
        $txt = implode("\r\n", $lines);
        $filename = 'quotation-' . preg_replace('/[^a-zA-Z0-9\-]/', '_', ($result['country'] ?? '') . '-' . ($result['service'] ?? '')) . '-' . date('Y-m-d-His') . '.txt';
        return response($txt, 200, [
            'Content-Type' => 'text/plain; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }
}
