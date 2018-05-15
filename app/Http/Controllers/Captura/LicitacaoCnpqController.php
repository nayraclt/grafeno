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

        $arrParams = $request->all();
        
        $this->tratandoErros($arrParams);
        
        $arrParams = http_build_query($arrParams);
                
        $requestOpts = array('http' =>
            array(
                'method'  => 'POST',
                'header'  => 'Content-type: application/x-www-form-urlencoded',
                'content' => $arrParams
            )
        );
        
        $contextRequest  = stream_context_create($requestOpts);
        
        $url = 'http://www.cnpq.br/web/guest/licitacoes?p_p_id=licitacoescnpqportlet_WAR_licitacoescnpqportlet_INSTANCE_BHfsvMBDwU0V&p_p_lifecycle=0&p_p_state=normal';

        $htmlCaptura = file_get_contents($url, false, $contextRequest);

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

        $objeto = $this->sanitizeString($objeto[0]);
        $abertura = $this->sanitizeString($abertura[0]);
        $publicacoes = $this->sanitizeString($publicacoes[0]);

        $arrLicitacao = [
            'titulo'=>$objeto,
            'conteudo'=>$abertura,
            'publicacoes'=>$publicacoes,
        ];

        return $arrLicitacao;
    }
    
        /**
     * @param $string
     * @return null|string|string[]
     * Retirando caracteres especiais
     */
    private function sanitizeString($string) {

        $str=preg_replace("@\n@","",$string);
        $str=preg_replace("@\t@","",$str);

        return $str;

    }
    
    /**
     * @param type $arrParams
     * Retorna erro caso informe um parâmetro que não seja válido
     */
    private function tratandoErros($arrParams){
        if($arrParams != []){
               
            if (!isset($arrParams['busca-licitacoes']) && !isset($arrParams['filtro-ano']) && !isset($arrParams['filtro-categoria']))
            {
                abort(412, 'O Parâmetro informado é inválido.'); // 412
            }

        }
        
    }
}

