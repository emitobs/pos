<?php

namespace App\Http\Livewire;

use App\Models\Client;
use App\Models\Payment_in;
use App\Models\Sale;
use Livewire\Component;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DebtsController extends Component
{

    public $selected_client, $amount, $last_payment = 'Sin entregas', $selected_debt;
    protected $listeners = [
        'save_payment'
    ];
    public function mount(Request $request)
    {
        if ($request->get('client_id')) {
            $client = Client::findOrFail($request->get('client_id'));
            if ($client) {
                $this->selected_client = $client;
            } else {
                return redirect('clients');
            }
        }
    }

    public function save_payment()
    {
        $rules = [
            'amount' => 'required|min:1|numeric'
        ];
        $messages = ['amount.required' => 'Ingrese monto a entregar', 'amount.numeric' => 'Ingrese un monto válido', 'amount.min' => 'El monto debese ser igual o mayor a $1'];
        if ($this->validate($rules, $messages)) {
            $new_payment = Payment_in::create([
                'amount' => $this->amount,
                'client_id' => $this->selected_client->id,
                'user_id' => Auth()->user()->id,
            ]);

            if ($new_payment) {
                $total = $this->amount;
                $client_debts = $this->selected_client->debts->sortBy('created_at');
                foreach ($client_debts as $debt) {
                    if ($total >= $debt->remaining) {
                        $total -= $debt->remaining;
                        $debt->remaining = 0;
                        $debt->payed = 1;
                        $debt->save();
                    } else {
                        $debt->remaining -= $total;
                        $debt->save();
                        $total -= $debt->total;
                        break;
                    }
                }
                if ($total > 0) {
                    $this->selected_client->balance += $total;
                    $this->selected_client->save();
                }
                $this->emit('payment_added');
            }
        } else {
            return abort(404);
        }
    }
    public function render()
    {
        if (Payment_in::where('client_id', $this->selected_client->id)->get()->count() > 0) {
            $last_payment = Payment_in::where('client_id', $this->selected_client->id)->orderBy('created_at', 'DESC')->first();
            if ($last_payment) $this->last_payment = '$ ' . $last_payment->amount . ' ' . Carbon::parse($last_payment->created_at)->format('d/m/Y H:i');
        }
        return view('livewire.debts.debts')->extends('layouts.theme.app')
            ->section('content');
    }

    public function seeDetail(Sale $debt)
    {
        $this->selected_debt = $debt;
        $this->emit('see_debt_details');
    }

    public function confirm_new_payment()
    {
        $rules = [
            'amount' => 'required|min:1|numeric'
        ];
        $messages = ['amount.required' => 'Ingrese monto a entregar', 'amount.numeric' => 'Ingrese un monto válido', 'amount.min' => 'El monto debese ser igual o mayor a $1'];
        dd($this->validate($rules, $messages));
        if ($this->amount)
            $this->emit('confirm_new_payment');
    }

    public function generatePDF()
    {
        session(['client_id' => $this->selected_client->id]);
        return redirect()->route('generatePDF');
    }

    public function resetUI()
    {
    }
}
