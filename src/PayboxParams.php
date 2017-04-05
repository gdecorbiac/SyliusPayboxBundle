<?php

namespace Gontran\SyliusPayboxBundle;


/**
 * Interface PayBoxRequestParams
 * @package Marem\PayumPaybox
 */
interface PayboxParams {

    // Default servers urls
    const SERVERS_PREPROD =  array('preprod-tpeweb.e-transactions.fr');
    const SERVERS_PROD =  array('tpeweb.e-transactions.fr', 'tpeweb1.e-transactions.fr');

    const URL_CLASSIC = 'cgi/MYchoix_pagepaiement.cgi';
    const URL_IFRAME = 'cgi/MYframepagepaiement_ip.cgi';
    const URL_MOBILE = 'cgi/ChoixPaiementMobile.cgi';
    
    const RETURN_FORMAT = 'Mt:M;Ref:R;Auto:A;Appel:T;Abo:B;Reponse:E;Transaction:S;Pays:Y;Signature:K';

    // Requests params
    const PBX_SITE = "PBX_SITE";
    const PBX_RANG = "PBX_RANG";
    const PBX_IDENTIFIANT = "PBX_IDENTIFIANT";
    const PBX_HASH = "PBX_HASH";
    const PBX_RETOUR = "PBX_RETOUR";
    const PBX_HMAC = "PBX_HMAC";
    const PBX_TYPEPAIEMENT = "PBX_TYPEPAIEMENT";
    const PBX_TYPECARTE = "PBX_TYPECARTE";
    const PBX_TOTAL = "PBX_TOTAL";
    const PBX_DEVISE = "PBX_DEVISE";
    const PBX_CMD = "PBX_CMD";
    const PBX_PORTEUR = "PBX_PORTEUR";
    const PBX_EFFECTUE = "PBX_EFFECTUE";
    const PBX_ANNULE = "PBX_ANNULE";
    const PBX_REFUSE = "PBX_REFUSE";
    const PBX_TIME = "PBX_TIME";
}
