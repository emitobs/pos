<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Payment_Out;
use App\Models\Payroll;
use Livewire\WithFileUploads;

class PaymentsOutController extends Component
{
    use WithFileUploads;

    public $componentName = 'Gastos',
    $selected_id = null,
    $amount,
    $description,
    $date,
    $receipt,
    $payrolls,
    $paymentOuts,
    $receipt_viewer;

    protected $listeners = [
        'openModalReceiptViewer'
    ];

    public function render()
    {
        $this->paymentOuts = Payment_Out::with('payroll')->get();
        $this->payrolls = Payroll::where('isClosed', 0)->get();
        return view('livewire.paymentsOut.payments-out')->extends('layouts.theme.app')
            ->section('content');
    }


    public function Store()
    {

        $paymentOut = Payment_Out::create([
            'amount' => $this->amount,
            'date' => $this->date,
            'reason' => $this->description,
            'user_id' => auth()->user()->id,
        ]);
        if ($this->receipt) {
            $customFileName = uniqid() . '_.' . $this->receipt->extension();
            $this->receipt->storeAs('public/paymentsout', $customFileName);
            $paymentOut->receipt = $customFileName;
            $paymentOut->save();
        }

    }


    public function resetUI()
    {
        $this->selected_id = null;
        $this->amount = null;
        $this->description = null;
        $this->date = null;
        $this->receipt = null;
    }

    public function openModalNewPaymentOut()
    {
        $this->emit('openModalNewPaymentOut');
    }

    public function openModalReceiptViewer($xreceipt)
    {
        $this->receipt_viewer = $xreceipt;
        $imageUrl = asset("storage/paymentsout/" . $xreceipt);
        $this->emit('xopenModalReceiptViewer', $imageUrl);
    }
}
