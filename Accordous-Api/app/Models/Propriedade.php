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
        $Propriedade = Propriedade::where('id', '=', $this->id)
        ->select('rua', 'numero', 'cidade', 'estado')
        ->first();
        
        $enderecoCompleto = '';
        $enderecoCompleto = $Propriedade->rua.', '.$Propriedade->numero.', '.$Propriedade->cidade.' - '.$Propriedade->estado;

            return $enderecoCompleto;
    }
    
    public function getStatusDescAttribute(){
        $Propriedade = Propriedade::where('id', '=', $this->id)
        ->select('status')
        ->first();
        
        $statusDesc = '';

        switch ($Propriedade->status) {
            case 'C':
                return 'Contratado';
                break;
            
            case 'N':
                return 'Não Contratado';
                break;
            
            default:
            $statusDesc = '';
                break;
        }
       
        return $statusDesc;
    }
}
