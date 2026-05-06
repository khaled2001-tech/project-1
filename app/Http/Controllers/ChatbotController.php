<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class ChatbotController extends Controller
{
    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:500',
            'history' => 'nullable|array',
        ]);

        // ── جلب السيارات من قاعدة البيانات ──────────────────────────
        $cars = DB::table('cars')
            ->join('brands', 'cars.brand_id', '=', 'brands.id')
            ->leftJoin('models', 'cars.model_id', '=', 'models.id')
            ->select(
                'cars.id',
                'cars.name',
                'cars.body_type',
                'cars.price',
                'cars.color',
                'cars.transmission_type',
                'cars.menufacturing_year',
                'cars.discount',
                'cars.status',
                'brands.name as brand_name',
                'models.name as model_name'
            )
            ->get();

        // ── تحويل السيارات إلى نص ────────────────────────────────────
        $carsText = $cars->map(function ($car) {
            $status   = $car->status ? 'متاحة' : 'غير متاحة';
            $discount = $car->discount > 0 ? "خصم {$car->discount}%" : 'لا يوجد خصم';
            $type     = $car->body_type === 'RENT' ? 'للإيجار' : 'للبيع';
            $model    = $car->model_name ? "({$car->model_name})" : '';
            return "• [{$car->id}] {$car->brand_name} {$car->name} {$model} | {$type} | السعر: \${$car->price} | اللون: {$car->color} | ناقل: {$car->transmission_type} | سنة: {$car->menufacturing_year} | الحالة: {$status} | {$discount}";
        })->join("\n");

        $totalAvailable = $cars->where('status', 1)->count();
        $forRent        = $cars->where('body_type', 'RENT')->where('status', 1)->count();
        $forSale        = $cars->where('body_type', 'BUY')->where('status', 1)->count();

        // ── System Prompt ─────────────────────────────────────────────
        $systemPrompt = "أنت مساعد ذكي لمعرض سيارات Cental. تساعد الزبائن في اختيار السيارة المناسبة للإيجار أو الشراء.

إحصائيات المعرض:
- إجمالي السيارات المتاحة: {$totalAvailable}
- للإيجار: {$forRent} سيارة
- للبيع: {$forSale} سيارة

قائمة السيارات الكاملة:
{$carsText}

تعليمات:
- أجب دائماً بالعربية بأسلوب ودي واحترافي.
- عند اقتراح سيارة اذكر اسمها وسعرها وحالتها.
- إذا سأل عن إيجار قل /Day بعد السعر.
- إذا طلب مقارنة قارن بشكل واضح.
- أجوبتك مختصرة وواضحة.";

        // ── بناء المحادثة لـ Gemini ───────────────────────────────────
        // Gemini يستخدم "contents" مع "parts"
        $contents = [];

        // إضافة تاريخ المحادثة
        if ($request->history) {
            foreach ($request->history as $turn) {
                if (isset($turn['role'], $turn['content'])) {
                    // Gemini يستخدم "user" و "model" (مش "assistant")
                    $geminiRole = $turn['role'] === 'assistant' ? 'model' : 'user';
                    $contents[] = [
                        'role'  => $geminiRole,
                        'parts' => [['text' => $turn['content']]],
                    ];
                }
            }
        }

        // رسالة المستخدم الجديدة
        $contents[] = [
            'role'  => 'user',
            'parts' => [['text' => $request->message]],
        ];

        // ── إرسال الطلب لـ Gemini API (مجاني) ───────────────────────
        $apiKey = config('services.gemini.key');

        $response = Http::timeout(30)
            ->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key={$apiKey}", [
                'system_instruction' => [
                    'parts' => [['text' => $systemPrompt]],
                ],
                'contents'           => $contents,
                'generationConfig'   => [
                    'maxOutputTokens' => 1024,
                    'temperature'     => 0.7,
                ],
            ]);

        if ($response->failed()) {
            return response()->json([
                'success' => false,
                'message' => 'عذراً، حدث خطأ في الاتصال. حاول مرة أخرى.',
            ], 500);
        }

        $data  = $response->json();
        $reply = $data['candidates'][0]['content']['parts'][0]['text']
                 ?? 'لم أتمكن من معالجة طلبك، حاول مرة أخرى.';

        return response()->json([
            'success' => true,
            'message' => $reply,
        ]);
    }
}
