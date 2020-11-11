<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use LaravelLegends\PtBrValidator\Rules\FormatoCpf;
use LaravelLegends\PtBrValidator\Rules\FormatoCnpj;

use App\Models\Contrato;

use DB;

class ContratoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Contrato = Contrato::all();

        if(count($Contrato) == 0){
            $retorno['tipo'] =  'erro';
            $retorno['mensagem'] = 'Nenhum registro encontrado.';
            return json_encode($retorno);
        }

        return $Contrato;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $Contrato = Contrato::find($request->id);

        if(empty($Contrato)){
            $retorno['tipo'] =  'erro';
            $retorno['mensagem'] = 'Nenhum registro encontrado.';
            return json_encode($retorno);
        }

        return json_encode($Contrato);
    }

    public function store(Request $request)
    {
        
        if($request->tipoPessoa == 'F'){
            $validaCpf = $this->validaCpf($request);

            $json = json_decode($validaCpf);

            if($json->{'tipo'} == 'erro'){
                return $validaCpf;
            }
        }
        
        if($request->tipoPessoa == 'J'){
            $validaCnpj = $this->validaCnpj($request);

            $json = json_decode($validaCnpj);

            if($json->{'tipo'} == 'erro'){
                return $validaCnpj;
            }
        }
        
        $validaCampos = $this->validaCampos($request);
        
        if($validaCampos['tipo'] == 'erro'){
            return json_encode($validaCampos);
        }

        DB::beginTransaction();

        try {
            $Contrato = new Contrato();
            $Contrato->propriedade_id   = $request->propriedade_id;
            $Contrato->tipoPessoa       = $request->tipoPessoa;
            $Contrato->documento        = $request->documento;
            $Contrato->emailContratante = $request->emailContratante;
            $Contrato->nomeContratante  = $request->nomeContratante;
            $Contrato->save();
            
            $PropriedadeController = new PropriedadeController();
            $atualizaStatus = $PropriedadeController->atualizaStatus($request->propriedade_id);
            $json = json_decode($atualizaStatus);

            if($json->{'tipo'} == 'erro'){
                return $atualizaStatus;
            }
            
            DB::commit();

            $retorno['tipo']     = 'sucesso';
            $retorno['mensagem'] = 'Contrato cadastrado com Sucesso.';
            return json_encode($retorno);
        } catch (\Throwable $th) {
            
            DB::rollback();

            $retorno['tipo'] =  'erro';
            $retorno['mensagem'] = 'Ops, ocorreu um erro ao tentar salvar os dados doa Contrato.';
            return json_encode($retorno);
        }
    }

    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $Contrato = Contrato::where('propriedade_id','=',$id)->delete();
        } catch (\Throwable $th) {
            $retorno['tipo'] =  'erro';
            $retorno['mensagem'] = 'Ops, ocorreu um erro ao tentar excluir os dados do contrato.';
            return json_encode($retorno);
        }

        $retorno['tipo']     = 'sucesso';
        $retorno['mensagem'] = 'Contrato excluído com Sucesso.';
        return json_encode($retorno);
    }

    public function validaCpf(Request $request){
        try{

            $dados = $request->validate([
                'documento'  => ['required', new FormatoCpf]
                // outras validações aqui
            ]);

            $retorno['tipo'] =  'sucesso';
            $retorno['mensagem'] = 'ok';
            return json_encode($retorno);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $erro = $e->errors();
            $retorno['tipo'] =  'erro';
            $retorno['mensagem'] = $erro['documento'][0];
            return json_encode($retorno);
        }
    }

    public function validaCnpj(Request $request){
        try{

            $dados = $request->validate([
                'documento'  => ['required', new FormatoCnpj]
                // outras validações aqui
            ]);
            $retorno['tipo'] =  'sucesso';
            $retorno['mensagem'] = 'ok';
            return json_encode($retorno);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $erro = $e->errors();
            $retorno['tipo'] =  'erro';
            $retorno['mensagem'] = $erro['documento'][0];
            return json_encode($retorno);
        }
    }

    public function validaCampos(Request $request){
        try{

            $mensagens = [
                'required' => ':attribute é obrigatório.',
                'email.email' => 'Digite um e-mail válido.',
                'min' => 'É necessário no mínimo :min caracteres no :attribute.',
                'max' => ':attribute não pode ser maior que :max.',
                'string' => ':attribute precisa ser uma String.',
                'integer' => ':attribute precisa ser um Inteiro.',
                'unique' => 'Propriedade já informada em outro contrato.'
            ];

            $request->validate([
                'propriedade_id' => 'required|integer|max:20|unique:contrato',
                'tipoPessoa' => 'required|string|max:1',
                'documento' => 'required|string|max:18',
                'emailContratante' => 'required|string|max:200|email',
                'nomeContratante' => 'required|string|max:200',
            ], $mensagens);
            
            $retorno['tipo'] = 'sucesso';
            $retorno['mensagem'] = 'ok';
            return $retorno;
        } catch (\Illuminate\Validation\ValidationException $e) {

            $mensagens = json_decode($e->validator->messages(), true);

            $retorno['tipo'] = 'erro';
            $retorno['mensagem'] = array();
            
            $campos = ['propriedade_id', 'tipoPessoa', 'documento', 'emailContratante', 'nomeContratante'];

            for ($i=0; $i < count($campos) ; $i++) { 

                if(isset($mensagens[$campos[$i]])){

                    foreach ($mensagens[$campos[$i]] as $key => $value) {
                        array_push($retorno['mensagem'], $value);
                    }
                }
            }
            // print_r($retorno['mensagem']);
            return $retorno;
        }
    }
}
