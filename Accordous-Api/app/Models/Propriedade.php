<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Propriedade extends Model
{
    use SoftDeletes;
    
    public $table = 'propriedade';

    protected $primaryKey = 'id';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    // protected $dates = ['deleted_at'];



    public $fillable = [
        'email',
        'rua',
        'numero',
        'complemento',
        'bairro',
        'cidade',
        'estado',
        'status',
       
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'email' => 'string',
        'rua' => 'string',
        'numero' => 'integer',
        'complemento' => 'string',
        'bairro' => 'string',
        'cidade' => 'string',
        'estado' => 'string',
        'status' => 'string',
        
    ];

    protected $appends = ['EnderecoCompleto', 'StatusDesc'];
    
    public function getEnderecoCompletoAttribute(){
        $Propriedade = Propriedade::select('rua', 'numero', 'cidade', 'estado')
        ->get();
        
        $enderecoCompleto = '';
        
        foreach ($Propriedade as $key => $value) {
            $enderecoCompleto = $value['rua'].', '.$value['numero'].', '.$value['cidade'].' - '.$value['estado'];
        }
        return $enderecoCompleto;
    }
    
    public function getStatusDescAttribute(){
        $Propriedade = Propriedade::select('status')
        ->get();
        
        $statusDesc = '';
        
        foreach ($Propriedade as $key => $value) {
            switch ($value['status']) {
                case 'C':
                    $statusDesc = 'Contratado';
                    break;
                
                case 'N':
                    $statusDesc = 'Não Contratado';
                    break;
                
                default:
                $statusDesc = '';
                    break;
            }
            
        }
        return $statusDesc;
    }
}
