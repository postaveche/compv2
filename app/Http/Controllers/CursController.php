<?php

namespace App\Http\Controllers;

use App\Models\Curs;

class CursController extends Controller
{
    public function index()
    {
        $last_day = Curs::latest()->first();
        $this_day = date('Y-m-d');
        //$this_day = '2022-06-15';
        if ($last_day['datacurs'] <> $this_day) {
            //echo $this_day;
            $curs_url = file_get_contents('https://www.curs.md/api/json/120254e1893558b9a30e9f0b3a404ab762a6e1b97ec262?lang=ru&date=' . $this_day);
            $get_curs = json_decode($curs_url, true);
            $valcurs = $get_curs['valcurs'];
            //dd($valcurs);
            if (empty($valcurs)) {
                return response(view('errors.404'), 404);
            }
            $maib_curs = $valcurs['0']['banks'];
            $all_val = $maib_curs['0']['valute'];
            $usd_sell = $all_val['0']['sell'];
            $usd_buy = $all_val['0']['buy'];
            $ron_sell = $all_val['1']['sell'];
            $ron_buy = $all_val['1']['buy'];
            $uah_sell = $all_val['2']['sell'];
            $uah_buy = $all_val['2']['buy'];
            $eur_sell = $all_val['3']['sell'];
            $eur_buy = $all_val['3']['buy'];
            $chf_sell = $all_val['4']['sell'];
            $chf_buy = $all_val['4']['buy'];
            $gbp_sell = $all_val['5']['sell'];
            $gbp_buy = $all_val['5']['buy'];

            $curses = new Curs();
            $curses->datacurs = $this_day;
            $curses->usd_sell = $usd_sell;
            $curses->usd_buy = $usd_buy;
            $curses->ron_sell = $ron_sell;
            $curses->ron_buy = $ron_buy;
            $curses->uah_sell = $uah_sell;
            $curses->uah_buy = $uah_buy;
            $curses->eur_sell = $eur_sell;
            $curses->eur_buy = $eur_buy;
            $curses->chf_sell = $chf_sell;
            $curses->chf_buy = $chf_buy;
            $curses->gbp_sell = $gbp_sell;
            $curses->gbp_buy = $gbp_buy;
            $curses->save();
            // dd($curses);
        }
    }
}
