<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Contrato extends Model
{
    use SoftDeletes;
    
    public $table = 'contrato';

    protected $primaryKey = 'id';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    // protected $dates = ['deleted_at'];



    public $fillable = [
        'propriedade_id',
        'tipoPessoa',
        'documento',
        'emailContratante',
        'nomeContratante',       
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'propriedade_id' => 'integer',
        'tipoPessoa' => 'string',
        'documento' => 'string',
        'emailContratante' => 'string',
        'nomeContratante' => 'string',
        
        
    ];

    protected $appends = ['Propriedade', 'TipoPessoaDesc'];
    
    public function getPropriedadeAttribute(){
        $Contrato = Contrato::where('contrato.id', '=', $this->id)
        ->Join('propriedade', 'propriedade.id', '=', 'contrato.propriedade_id')
        ->select('propriedade.rua', 'propriedade.numero', 'propriedade.cidade', 'propriedade.estado')
        ->first();
        
        $enderecoCompleto = '';
        
        $enderecoCompleto = $Contrato->rua.', '.$Contrato->numero.', '.$Contrato->cidade.' - '.$Contrato->estado;

        return $enderecoCompleto;
    }
    
    public function getTipoPessoaDescAttribute(){
        $Contrato = Contrato::where('contrato.id', '=', $this->id)
        ->select('tipoPessoa')
        ->first();
        
        $TipoPessoaDesc = '';
        
        switch ($Contrato->tipoPessoa) {
            case 'F':
                return 'Física';
                break;
            
            case 'J':
                return 'Jurídica';
                break;
            
            default:
            $statusDesc = '';
                break;
        }

        return $TipoPessoaDesc;
    }
}
