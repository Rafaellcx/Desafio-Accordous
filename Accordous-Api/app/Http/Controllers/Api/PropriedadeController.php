<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Propriedade;

use DB;

class PropriedadeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Propriedade = Propriedade::all();

        if(count($Propriedade) == 0){
            $retorno['tipo'] =  'erro';
            $retorno['mensagem'] = 'Nenhum registro encontrado.';
            return json_encode($retorno);
        }

        return $Propriedade;
    }

     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validaCampos = $this->validaCampos($request);

        if($validaCampos['tipo'] == 'erro'){
            return json_encode($validaCampos);
        }

        try {
            $Propriedade = new Propriedade();
            $Propriedade->email       = $request->email;
            $Propriedade->rua         = $request->rua;
            $Propriedade->numero      = $request->numero;
            $Propriedade->complemento = $request->complemento;
            $Propriedade->bairro      = $request->bairro;
            $Propriedade->cidade      = $request->cidade;
            $Propriedade->estado      = $request->estado;
            $Propriedade->status      = 'N';//'Não Contratado' - OBS: Após Criar o Contrato, atualizar o Status para "C - Contratado".
            $Propriedade->save();

            $retorno['tipo']     = 'sucesso';
            $retorno['mensagem'] = 'Propriedade cadastrada com Sucesso.';
            return json_encode($retorno);
        } catch (\Throwable $th) {
            $retorno['tipo'] =  'erro';
            $retorno['mensagem'] = 'Ops, ocorreu um erro ao tentar salvar os dados da Propriedade.';
            return json_encode($retorno);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        DB::beginTransaction();

        try {
            $Propriedade = Propriedade::where('id', '=', $request->id)->delete();
           
            if(!$Propriedade){
                $retorno['tipo'] =  'erro';
                $retorno['mensagem'] = 'Ops, propriedade não encontrada.';
                return json_encode($retorno);
            }

            $ContratoController = new ContratoController();
            $destroyContrato = $ContratoController->destroy($request->id);

            $json = json_decode($destroyContrato);
            
            if($json->{'tipo'} == 'erro'){
                return $retorno;
            }

            DB::commit();

            $retorno['tipo']     = 'sucesso';
            $retorno['mensagem'] = 'Propriedade excluída com Sucesso.';
            return json_encode($retorno);

        } catch (\Throwable $th) {
            DB::rollback();

            $retorno['tipo'] =  'erro';
            $retorno['mensagem'] = 'Ops, ocorreu um erro ao tentar excluir os dados da propriedade.';
            return json_encode($retorno);
        }

        
    }

    public function atualizaStatus($id){

        try {
            $Propriedade = Propriedade::find($id)
            ->update(['status'=>'C']); //OBS: Após Criar o Contrato, atualizar o Status para "C - Contratado".
        } catch (\Throwable $th) {
            $retorno['tipo'] =  'erro';
            $retorno['mensagem'] = 'Ops, ocorreu um erro ao tentar atualizar o status da propriedade.';
            return json_encode($retorno);
        }

        $retorno['tipo']     = 'sucesso';
        $retorno['mensagem'] = 'Status atualizado com Sucesso.';
        return json_encode($retorno);

    }

    public function validaCampos(Request $request){
        try{

            $mensagens = [
                'required' => ':attribute é obrigatório.',
                'email.email' => 'Digite um e-mail válido.',
                'min' => 'É necessário no mínimo :min caracteres no :attribute.',
                'max' => ':attribute não pode ser maior que :max.',
                'string' => ':attribute precisa ser uma String.',
                'integer' => ':attribute precisa ser um Inteiro.'
            ];
        
            $request->validate([
                'email'        => 'required|string|max:200|email',
                'rua'          => 'nullable|string|max:100',
                'numero'       => 'nullable|integer|max:99999',
                'bairro'       => 'nullable|string|max:100',
                'cidade'       => 'nullable|string|max:100',
                'estado'       => 'nullable|string|max:2',
            ], $mensagens);
            
            $retorno['tipo'] = 'sucesso';
            $retorno['mensagem'] = 'ok';
            return $retorno;
        } catch (\Illuminate\Validation\ValidationException $e) {

            $mensagens = json_decode($e->validator->messages(), true);

            $retorno['tipo'] = 'erro';
            $retorno['mensagem'] = array();
            
            $campos = ['email', 'rua', 'numero', 'bairro', 'cidade', 'estado', 'cep'];

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
