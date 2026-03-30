<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use App\Models\SliderItem;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    // Tracking afișări (apelat via AJAX)
    public function trackView(Request $request)
    {
        $ids = $request->input('ids', []);
        if (!empty($ids)) {
            SliderItem::whereIn('id', $ids)->increment('views');
        }
        return response()->json(['ok' => true]);
    }

    // Tracking click (apelat via AJAX)
    public function trackClick($id)
    {
        $item = SliderItem::find($id);
        if ($item) {
            $item->increment('clicks');
            return response()->json(['ok' => true]);
        }
        return response()->json(['ok' => false], 404);
    }

    // Helper static: obține slidere pentru o poziție
    public static function getSliders($position, $categoryId = null)
    {
        $query = Slider::where('active', 1)
            ->where('position', $position)
            ->with('activeItems')
            ->orderBy('sort_order');

        $sliders = $query->get();

        // Filtrare pentru categorii specifice
        if ($position === 'category' && $categoryId) {
            $sliders = $sliders->filter(function ($slider) use ($categoryId) {
                $ids = $slider->category_ids;
                return empty($ids) || in_array($categoryId, $ids);
            });
        }

        return $sliders;
    }
}
