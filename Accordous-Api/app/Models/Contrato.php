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

    protected $appends = ['Propriedade'];
    
    public function getPropriedadeAttribute(){
        $Contrato = Contrato::Join('propriedade', 'propriedade.id', '=', 'contrato.propriedade_id')
        ->select('propriedade.rua', 'propriedade.numero', 'propriedade.cidade', 'propriedade.estado')
        ->get();
        
        $enderecoCompleto = '';
        
        foreach ($Contrato as $key => $value) {
            $enderecoCompleto = $value['rua'].', '.$value['numero'].', '.$value['cidade'].' - '.$value['estado'];
        }
        return $enderecoCompleto;
    }
}
