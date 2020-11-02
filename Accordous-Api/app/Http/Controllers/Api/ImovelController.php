<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Imovel;

class ImovelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            $Imovel = new Imovel();
            $Imovel->email       = 
            $Imovel->rua         = $request->rua;
            $Imovel->numero      = $request->numero;
            $Imovel->complemento = $request->complemento;
            $Imovel->bairro      = $request->bairro;
            $Imovel->cidade      = $request->cidade;
            $Imovel->estado      = $request->estado;
            $Imovel->save();

            $retorno['tipo']     = 'sucesso';
            $retorno['mensagem'] = 'Imóvel cadastrado com Sucesso.';
            return json_encode($retorno);
        } catch (\Throwable $th) {
            $retorno['tipo'] =  'erro';
            $retorno['mensagem'] = 'Ops, ocorreu um erro ao tentar salvar os dados do imóvel.';
            return json_encode($retorno);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
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
