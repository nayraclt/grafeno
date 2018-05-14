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

        $arrRetornoTratado = $this->tratandoHtmlApresentacao($htmlCaptura);

        
        return $arrRetornoTratado;

    }
    
    /**
     * 
     * @param type $html
     * @return array
     */
    private function tratandoHtmlApresentacao($html)
    {

        $doc = new \DOMDocument();

        @$doc->loadHTML($html);

        $tables = $doc->getElementsByTagName('tbody');

        $rows = $tables->item(0)->getElementsByTagName('tr');

        $arrLicitacoes = [];

        // loop over the table rows
        foreach ($rows as $row)
        {
            // get each column by tag name
            $cols = $row->getElementsByTagName('td');

            //Interando o arry de retornn
            array_push($arrLicitacoes, $this->tratandoRetorno($cols));
        }

        return $arrLicitacoes;
    }
    
        /**
     * 
     * @param type $cols
     * @return array
     */
    private function tratandoRetorno($cols){        
        $objeto = explode('Objeto', $cols->item(0)->nodeValue);
        $abertura = explode('Abertura', $objeto[1]);
        $publicacoes = explode('Publicações', $abertura['1']);

//            dd(strip_tags($objeto[0]), $abertura[0], $publicacoes[0]);

        $objeto = $objeto[0];
        $abertura = $abertura[0];
        $publicacoes = $publicacoes[0];

        $arrLicitacao = [
            'objeto'=>$objeto,
            'abertura'=>$abertura,
            'publicacoes'=>$publicacoes,
        ];

        return $arrLicitacao;
    }
}

