<?php

namespace Ahelos\Http\Controllers;

use Ahelos\Printer;
use Ahelos\PrinterInk;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class PrinterInkController extends Controller
{
    /**
     * @param Printer $printer
     * @return int|string
     */
    public function showInks(Printer $printer)
    {
        $inks = PrinterInk::where('printer_id', '=', $printer->id)->select('id', 'name')->get();

        if ($inks === null) {
            return 0;
        }

        $html = "";

        foreach ($inks as $ink) {
            $html .= "<option value='" . $ink->id . "'>" . $ink->name . "</option>";
        }

        return $html;
    }

    /**
     * @param Printer $printer
     * @return Response
     */
    public function show(Printer $printer)
    {
        $printer->load('inks');

        return view('add_ink', compact('printer'));
    }

    /**
     * @param Request $request
     * @param Printer $printer
     * @return RedirectResponse
     */
    public function store(Request $request, Printer $printer)
    {
        $data = $request->except('_token');

        $restored = 0;

        foreach ($printer->withTrashedInks as $ink) {
            if ($ink->name === $data['ink']) {
                if (!$ink->trashed()) {
                    return back()->with('warning', 'Ova tinta već postoji za navedeni printer.');
                }
                $ink->restore();
                $restored = 1;
            }
        }

        if ($restored === 0) {
            PrinterInk::create([
                'printer_id' => $printer->id,
                'name' => $data['ink']
            ]);
        }

        return back()->with('success', 'Tinta je uspješno dodana.');
    }

    /**
     * @param Printer $printer
     * @param PrinterInk $ink
     * @return RedirectResponse
     */
    public function delete(Printer $printer, PrinterInk $ink)
    {
        if (Auth::user()->admin || Auth::user()->id === $ink->printer->user->id) {
            $ink->delete();
            return back()->with('success', 'Tinta je uspješno obrisana.');
        }

        return back()->with('warning', 'Nemate ovlasti za obrisati ovu tintu/toner.');
    }
}
