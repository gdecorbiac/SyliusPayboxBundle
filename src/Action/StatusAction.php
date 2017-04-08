<?php
namespace Gontran\SyliusPayboxBundle\Action;

use Payum\Core\Action\ActionInterface;
use Payum\Core\Request\GetStatusInterface;
use Payum\Core\Request\GetToken;
use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\Exception\RequestNotSupportedException;
use Payum\Core\GatewayAwareTrait;
use Payum\Core\GatewayAwareInterface;
use Sylius\Bundle\PayumBundle\Request\GetStatus;
use Sylius\Component\Payment\Model\PaymentInterface;

class StatusAction implements ActionInterface, GatewayAwareInterface
{
    use GatewayAwareTrait;

    const RESPONSE_SUCCESS = "00000";
    const RESPONSE_FAILED_MIN = "00100";
    const RESPONSE_FAILED_MAX = "00199";
    //TODO: handle other response codes


    /**
     * {@inheritDoc}
     *
     * @param GetStatusInterface $request
     */
    public function execute($request)
    {
        RequestNotSupportedException::assertSupports($this, $request);

        $model = ArrayObject::ensureArrayObject($request->getModel());


        if (null === $model['error_code']) {
            $request->markNew();
            return;
        }

        // Rely only on NotifyAction to update payment
        if (isset($model['notification_pending'])) {

            if (self::RESPONSE_SUCCESS === $model['error_code']) {
                $request->markCaptured();
            }
            else if (self::RESPONSE_FAILED_MIN <= $model['error_code'] && self::RESPONSE_FAILED_MAX >= $model['error_code']) {
                $request->markFailed();
            }
            else {
                $request->markCanceled();
            }
            unset($model['notification_pending']);
        }
        else {
            // To make Sylius display a correct message (PayumController:afterCaptureAction)
            // And because request is in state unknown
            // Let's mark the request with the state of the payment
            // Because IPN notification will always be handled by the server before user action
            $paymentState = $request->getFirstModel()->getState();

            switch ($paymentState) {
                case PaymentInterface::STATE_NEW:
                    $request->markNew();
                    break;

                case PaymentInterface::STATE_COMPLETED:
                    $request->markCaptured();

                case PaymentInterface::STATE_FAILED:
                    $request->markFailed();

                default:
                    $request->markCanceled();
                    break;
            }

        }
    }

    /**
     * {@inheritDoc}
     */
    public function supports($request)
    {
        return
            $request instanceof GetStatusInterface &&
            $request->getModel() instanceof \ArrayAccess
        ;
    }
}
