<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{


  public function confirmTransaction(Request $request)
{
  if ($transaction = Transaction::find($request->get('ThirdPartyTransID'))) {
      $transaction->update(['status' => Transaction::STATUS_COMPLETE]);
      return $this->successfulResponse($transaction);
  }
  if (!$invoice = $this->getInvoice($request->get('BillRefNumber', 0))) {
      return $this->invalidInvoiceNumberResponse();
  }
  $transaction = $this->createTransaction($request, $invoice, Transaction::STATUS_COMPLETE);
  return $this->successfulResponse($transaction);
}

protected function successfulResponse(Transaction $transaction)
  {
      return response()->json([
          'ResultCode' => 0,
          'ResultDesc' => 'The service was accepted successfully',
          'ThirdPartyTransID' => $transaction->id
      ]);
  }
  /**
   * Send an invalid invoice number response
   *
   * @return Response
   */
  protected function invalidInvoiceNumberResponse()
  {
      return response()->json([
          'ResultCode' => 1,
          'ResultDesc' => 'The provided invoice number does not exist.',
          'ThirdPartyTransID' => 0
      ]);
  }








}
