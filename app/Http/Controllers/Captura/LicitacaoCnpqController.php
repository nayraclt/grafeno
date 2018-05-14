<?php

namespace App\Http\Controllers\Captura;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LicitacaoCnpqController extends Controller
{
    /**
     * 
     * @param Request $request
     * @return array
     */
    public function buscarLicitacoesCNPQ(Request $request){        

        $url = 'http://www.cnpq.br/web/guest/licitacoes?p_p_id=licitacoescnpqportlet_WAR_licitacoescnpqportlet_INSTANCE_BHfsvMBDwU0V&p_p_lifecycle=0&p_p_state=normal';

        $htmlCaptura = file_get_contents($url);

        return $htmlCaptura;

    }
}

