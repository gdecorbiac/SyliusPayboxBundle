<?php
namespace Gontran\SyliusPayboxBundle;

use Gontran\SyliusPayboxBundle\Action\AuthorizeAction;
use Gontran\SyliusPayboxBundle\Action\CancelAction;
use Gontran\SyliusPayboxBundle\Action\ConvertPaymentAction;
use Gontran\SyliusPayboxBundle\Action\CaptureAction;
use Gontran\SyliusPayboxBundle\Action\NotifyAction;
use Gontran\SyliusPayboxBundle\Action\RefundAction;
use Gontran\SyliusPayboxBundle\Action\StatusAction;
use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\GatewayFactory;

class PayboxGatewayFactory extends GatewayFactory
{
    /**
     * {@inheritDoc}
     */
    protected function populateConfig(ArrayObject $config)
    {
        $config->defaults([
            'payum.factory_name' => 'paybox',
            'payum.factory_title' => 'Paybox',
            'payum.action.capture' => new CaptureAction(),
            'payum.action.authorize' => new AuthorizeAction(),
            'payum.action.refund' => new RefundAction(),
            'payum.action.cancel' => new CancelAction(),
            'payum.action.notify' => new NotifyAction(),
            'payum.action.status' => new StatusAction(),
            'payum.action.convert_payment' => new ConvertPaymentAction(),
        ]);

        if (false == $config['payum.api']) {
            $config['payum.default_options'] = array(
                'site' => '',
                'rang' => '',
                'identifiant' => '',
                'hmac' => '',
                'hash' => 'SHA512',
                'retour' => 'Mt:M;Ref:R;Auto:A;Appel:T;Abo:B;Reponse:E;Transaction:S;Pays:Y;Signature:K',
                'sandbox' => true,
                'type_paiement' => '',
                'type_carte' => ''
            );
            $config->defaults($config['payum.default_options']);
            $config['payum.required_options'] = array('site', 'rang', 'identifiant', 'hmac');

            $config['payum.api'] = function (ArrayObject $config) {
                $config->validateNotEmpty($config['payum.required_options']);

                return new Api((array) $config, $config['payum.http_client'], $config['httplug.message_factory']);
            };
        }
    }
}
