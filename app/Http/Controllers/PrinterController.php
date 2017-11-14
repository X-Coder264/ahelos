<?php

namespace Ahelos\Http\Controllers;

use Ahelos\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Ahelos\Printer;
use Illuminate\Support\Facades\Auth;

class PrinterController extends Controller
{
    /**
     * @param Request $request
     * @param User $user
     * @return RedirectResponse
     */
    public function store(Request $request, User $user)
    {
        $input = $request->all();
        
        if (Auth::user()->admin) {
            $input['user_id'] = $user->id;
        }

        $user->load(['printers' => function($query) {
            $query->withTrashed();
        }])->get();

        foreach ($user->printers as $printer) {
            if ($printer->name === $input['name']) {
                $printer->restore();
                return back();
            }
        }

        $user->newPrinter($input);

        return back()->with('success', 'Printer je uspješno dodan.');
    }

    /**
     * @param Request $request
     * @param Printer $printer
     * @return RedirectResponse
     */
    public function delete(Request $request, Printer $printer)
    {
        if (Auth::user()->admin || Auth::user()->id == $printer->user_id) {
            $printer->delete();
            return back()->with('success', 'Printer je deaktiviran.');
        }

        return back()->with('warning', 'Nemate ovlasti za obrisati ovaj printer.');
    }

    /**
     * @param Request $request
     * @param $printer
     * @return RedirectResponse
     */
    public function restore(Request $request, $printer)
    {
        $printer = Printer::withTrashed()->find($printer);

        $printer->restore();

        return back()->with('success', 'Printer je aktiviran.');
    }

    /**
     * @param Request $request
     * @param Printer $printer
     * @return RedirectResponse
     */
    public function update(Request $request, Printer $printer)
    {
        $printer->name = $request->input('printer');
        $printer->save();
        return back()->with('success', 'Ime printera je uspješno izmjenjeno.');
    }
}
