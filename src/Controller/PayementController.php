<?php

namespace App\Controller;

use PayPal\Api\Item;
use PayPal\Api\Payer;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Payment;
use PayPal\Api\ItemList;
use PayPal\Api\Transaction;
use PayPal\Rest\ApiContext;
use PayPal\Api\RedirectUrls;
use PayPal\Auth\OAuthTokenCredential;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PayementController extends AbstractController
{
    /**
     * @Route("/payement-paypal", name="payement via paypal")
     */
    public function index()
    {
        $apiContext = new ApiContext(
            new OAuthTokenCredential(
                'AVxjjGdr6Rag87kXASz-yYcJTjmwrIbFxOOQHSglOG94q9JtbtzwrK8mx6ouiina1koq8a2y_HCS40iL',
                'EN-dTVxk1pFQdTnoUAQteMUciup3ZQV6uoQsVejrdSQz7cKb7Kqev3TRzQ-qOHwmVva523n24k5Zajir'
            )
        );
    
        $payement = new Payment();
        $payement->create($apiContext);

        $payement->setIntent('sale');

        

        $list = new ItemList();

        $item = (new Item())
                ->setName('Attestation de débarquement')
                ->setPrice(5)
                ->setCurrency('EUR')
                ->setQuantity(1)
        ;

        $list->addItem($item);

        $details = (new Details())
                ->setSubtotal(5)
        ;

        $amount = (new Amount())
                ->setTotal(5)
                ->setCurrency('EUR')
                ->setDetails($details)
        ;

        $transaction = (new Transaction())
                    ->setItemList($list)
                    ->setDescription('Payement en ligne eVisa Madagascar')
                    ->setAmount($amount)
                    ->setCustom('demo-1')
        ;

        $payement->setTransactions($transaction);

        $redirectUrls = (new RedirectUrls())
                        ->setReturnUrl('/payement-ok')
                        ->setCancelUrl('/payement-ko')
        ;

        $payement->setRedirectUrls($redirectUrls);

        $payement->setPayer((new Payer())->setPaymentMethod('paypal'));

        echo $payement->getApprovalLink();
        dump($payement);die;
    }

     /**
     * @Route("/payement-ok", name="payement ok")
     */
    public function payement_ok()
    {
       
        dump("payement ok");die;
    }

     /**
     * @Route("/payement-ko", name="payement ko")
     */
    public function payement_ko()
    {
       
        dump("payement ko");die;
    }
}
